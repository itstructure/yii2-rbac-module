<?php

namespace Itstructure\RbacModule\controllers;

use Itstructure\RbacModule\models\{Role, RoleSearch};

/**
 * Class RoleController
 * RoleController implements the CRUD actions for Role model.
 *
 * @package Itstructure\RbacModule\controllers
 */
class RoleController extends BaseController
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
     * Returns Role model name.
     *
     * @return string
     */
    protected function getModelName(): string
    {
        return Role::class;
    }

    /**
     * Returns RoleSearch model name.
     *
     * @return string|null
     */
    protected function getSearchModelName(): string
    {
        return RoleSearch::class;
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
