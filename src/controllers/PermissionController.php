<?php

namespace Itstructure\RbacModule\controllers;

use Itstructure\RbacModule\models\{Permission, PermissionSearch};

/**
 * Class PermissionController
 * PermissionController implements the CRUD actions for Permission model.
 *
 * @package Itstructure\RbacModule\controllers
 */
class PermissionController extends BaseController
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
     * Returns Permission model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Permission::class;
    }

    /**
     * Returns PermissionSearch model name.
     *
     * @return string|null
     */
    protected function getSearchModelName():string
    {
        return PermissionSearch::class;
    }

    /**
     * Returns new object of search main model.
     *
     * @return mixed
     */
    protected function getNewSearchModel()
    {
        return parent::getNewSearchModel()->setAuthManager($this->validateComponent->getAuthManager());
    }
}
