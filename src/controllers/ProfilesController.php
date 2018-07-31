<?php

namespace Itstructure\RbacModule\controllers;

/**
 * Class ProfilesController
 * ProfilesController implements the CRUD actions for identityClass.
 *
 * @package Itstructure\RbacModule\controllers
 */
class ProfilesController extends BaseController
{
    /**
     * Initialize.
     * Set validateComponent and additionFields.
     */
    public function init()
    {
        $this->viewPath = '@rbac/views/profiles';

        $this->validateComponent = $this->module->get('profile-validate-component');

        parent::init();
    }

    /**
     * Returns addition fields.
     *
     * @return array
     */
    protected function getAdditionFields(): array
    {
        $additionFields = [];

        if ($this->action->id == 'update'){
            $additionFields['roles'] = $this->validateComponent->getAuthManager()->getRoles();
        }

        return $additionFields;
    }

    /**
     * Returns identityClass model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return \Yii::$app->user->identityClass;
    }

    /**
     * Returns identityClass Search model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return \Yii::$app->user->identityClass . 'Search';
    }
}
