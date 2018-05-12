<?php

namespace Itstructure\RbacModule\controllers;

use yii\data\ArrayDataProvider;
use Itstructure\RbacModule\models\Permission;

/**
 * Class PermissionsController
 * PermissionsController implements the CRUD actions for Permission model.
 *
 * @package Itstructure\RbacModule\controllers
 */
class PermissionsController extends BaseController
{
    /**
     * Initialize.
     * Set viewPath and validateComponent.
     */
    public function init()
    {
        $this->viewPath = '@rbac/views/permissions';

        $this->validateComponent = $this->module->get('rbac-validate-component');

        parent::init();
    }

    /**
     * List of permissions.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->validateComponent->getAuthManager()->getPermissions()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Returns Permission model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Permission::class;
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
