<?php

namespace Itstructure\RbacModule\controllers;

use yii\data\ArrayDataProvider;
use Itstructure\RbacModule\models\Role;

/**
 * Class RolesController
 * RolesController implements the CRUD actions for Role model.
 *
 * @package Itstructure\RbacModule\controllers
 */
class RolesController extends BaseController
{
    /**
     * Initialize.
     * Set viewPath and validateComponent.
     */
    public function init()
    {
        $this->viewPath = '@rbac/views/roles';

        $this->validateComponent = $this->module->get('rbac-validate-component');

        parent::init();
    }

    /**
     * List of roles.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->validateComponent->getAuthManager()->getRoles()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Returns Role model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Role::class;
    }

    /**
     * Returns null.
     *
     * @return string|null
     */
    protected function getSearchModelName():string
    {
        return null;
    }
}
