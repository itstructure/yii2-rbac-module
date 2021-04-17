<?php

namespace Itstructure\RbacModule\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\{VerbFilter, AccessControl};
use yii\base\{Model, UnknownMethodException};
use yii\web\{BadRequestHttpException, ConflictHttpException, NotFoundHttpException, Controller};
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\interfaces\{ModelInterface, ValidateComponentInterface, RbacIdentityInterface};

/**
 * Class BaseController
 * Base controller class for the `Rbac` module.
 *
 * @property Module $module
 * @property bool $viewCreated
 * @property array $additionFields
 * @property array $additionAttributes
 * @property string $urlPrefix Url prefix for redirect and view links.
 * @property string $urlPrefixNeighbor Url prefix for redirect and view links of neighbor entity.
 * @property ModelInterface $model
 * @property Model $searchModel
 * @property ValidateComponentInterface $validateComponent
 *
 * @package Itstructure\RbacModule\controllers
 */
abstract class BaseController extends Controller
{
    /**
     * Watch or not created record.
     *
     * @var bool
     */
    protected $viewCreated = false;

    /**
     * Addition fields for the template.
     *
     * @var array
     */
    protected $additionFields = [];

    /**
     * Addition attributes with values for the model.
     * [
     *    'key1' => 'value1',
     *    'key2' => 'value2',
     * ]
     *
     * @var array
     */
    protected $additionAttributes = [];

    /**
     * Url prefix for redirect and view links.
     *
     * @var string
     */
    protected $urlPrefix = '';

    /**
     * Url prefix for redirect and view links of neighbor entity.
     *
     * @var string
     */
    protected $urlPrefixNeighbor = '';

    /**
     * Model object record.
     *
     * @var ModelInterface
     */
    private $model;

    /**
     * Search new model object.
     *
     * @var Model
     */
    private $searchModel;

    /**
     * Multilanguage component.
     *
     * @var ValidateComponentInterface
     */
    private $validateComponent;

    /**
     * Returns the name of the base model.
     *
     * @return string
     */
    abstract protected function getModelName(): string;

    /**
     * Returns the name of the model to search it.
     *
     * @return string
     */
    abstract protected function getSearchModelName(): string;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->accessRoles,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => [
                        'POST',
                    ],
                ],
            ],
        ];
    }

    /**
     * Initializer.
     */
    public function init()
    {
        parent::init();

        $this->view->params['user'] = Yii::$app->user->identity;
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['urlPrefix']         = $this->urlPrefix;
        $this->view->params['urlPrefixNeighbor'] = $this->urlPrefixNeighbor;

        return parent::beforeAction($action);
    }

    /**
     * Give ability of configure view to the module class.
     *
     * @return \yii\base\View|\yii\web\View
     */
    public function getView()
    {
        if (method_exists($this->module, 'getView')) {
            return $this->module->getView();
        }

        return parent::getView();
    }

    /**
     * Set model.
     *
     * @param $model ModelInterface
     */
    public function setModel(ModelInterface $model): void
    {
        $this->model = $model;
    }

    /**
     * Set search model.
     *
     * @param $model Model
     */
    public function setSearchModel(Model $model): void
    {
        $this->searchModel = $model;
    }

    /**
     * Set validate component for main model.
     *
     * @param $component ValidateComponentInterface
     */
    public function setValidateComponent(ValidateComponentInterface $component): void
    {
        $this->validateComponent = $component;
    }

    /**
     * Returns model.
     *
     * @return ModelInterface
     */
    public function getModel(): ModelInterface
    {
        return $this->model;
    }

    /**
     * Returns search model.
     *
     * @return Model
     */
    public function getSearchModel(): Model
    {
        return $this->searchModel;
    }

    /**
     * Get validate component for main model.
     *
     * @return ValidateComponentInterface
     */
    public function getValidateComponent(): ValidateComponentInterface
    {
        return $this->validateComponent;
    }

    /**
     * List of records.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->setSearchModel(
            $this->getNewSearchModel()
        );

        return $this->render('index',
            ArrayHelper::merge(
                [
                    'searchModel' => $this->searchModel,
                    'dataProvider' => $this->searchModel->search(Yii::$app->request->queryParams),
                ],
                $this->getAdditionFields()
            )
        );
    }

    /**
     * Displays one model entry.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view',
            ArrayHelper::merge(
                [
                    'model' => $this->findModel($id),
                ],
                $this->getAdditionFields()
            )
        );
    }

    /**
     * Creates a new model record.
     * If the result of creation is successful, there will be a redirect to the 'view' or 'index' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->setModelByConditions();

        if (Yii::$app->request->isPost &&
            $this->model->load(Yii::$app->request->post()) &&
            $this->setAdditionAttributes() &&
            $this->model->save()) {

            if ($this->viewCreated) {
                $redirectParams = [
                    $this->urlPrefix.'view',
                    'id' => $this->model->getId(),
                ];
            } else {
                $redirectParams = [
                    $this->urlPrefix.'index',
                ];
            }

            return $this->redirect($redirectParams);
        }

        return $this->render('create',
            ArrayHelper::merge(
                [
                    'model' => $this->model,
                ],
                $this->getAdditionFields()
            )
        );
    }

    /**
     * Updates the current model entry.
     * If the result of creation is successful, there will be a redirect to the 'view' or 'index' page.
     *
     * @param int|string $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $this->setModelByConditions($id);

        if (Yii::$app->request->isPost &&
            $this->model->load(Yii::$app->request->post()) &&
            $this->setAdditionAttributes() &&
            $this->model->save()) {

            return $this->redirect([
                $this->urlPrefix.'view',
                'id' => $this->model->getId(),
            ]);
        }

        return $this->render('update',
            ArrayHelper::merge(
                [
                    'model' => $this->model,
                ],
                $this->getAdditionFields()
            )
        );
    }

    /**
     * Deletes the current model entry.
     * If the result of the deletion is successful, there will be a redirect to the 'index' page.
     *
     * @param int|string $id
     *
     * @throws ConflictHttpException
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (($model instanceof RbacIdentityInterface) && $id == Yii::$app->user->identity->getId()) {
            throw new ConflictHttpException('You can not delete yourself.');
        };

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Set addition attributes for model.
     *
     * @return bool
     */
    protected function setAdditionAttributes(): bool
    {
        $this->model->setAttributes($this->additionAttributes, false);

        return true;
    }

    /**
     * Get addition fields for the view template.
     *
     * @return array
     */
    protected function getAdditionFields(): array
    {
        return $this->additionFields;
    }

    /**
     * Returns new object of main model.
     *
     * @return mixed
     */
    protected function getNewModel()
    {
        $modelName = $this->getModelName();
        return new $modelName;
    }

    /**
     * Returns new object of search main model.
     *
     * @return RbacIdentityInterface|ModelInterface
     */
    protected function getNewSearchModel()
    {
        $searchModelName = $this->getSearchModelName();
        return new $searchModelName;
    }

    /**
     * Find model record.
     * If the model is not found, a 404 HTTP exception will be displayed.
     *
     * @param int|string $key
     *
     *
     * @throws BadRequestHttpException
     * @throws UnknownMethodException
     * @throws NotFoundHttpException
     *
     * @return mixed
     */
    private function findModel($key)
    {
        if (null === $key) {
            throw new BadRequestHttpException('Key parameter is not defined in findModel method.');
        }

        $modelObject = $this->getNewModel();

        if (!method_exists($modelObject, 'findOne')) {
            $class = (new\ReflectionClass($modelObject));
            throw new UnknownMethodException('Method findOne does not exists in ' . $class->getNamespaceName() . '\\' .
                $class->getShortName().' class.');
        }

        $result = call_user_func([
            $modelObject,
            'findOne',
        ], $key);

        if ($result !== null) {
            return $result;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Returns an intermediate model for working with the main.
     *
     * @param int|string|null $key
     *
     * @return void
     */
    private function setModelByConditions($key = null): void
    {
        $model = null === $key ? $this->getNewModel() : $this->findModel($key);

        if (null === $this->validateComponent) {
            $this->setModel($model);
        } else {
            $this->setModel(
                $this->validateComponent->setModel($model)
            );
        }
    }
}
