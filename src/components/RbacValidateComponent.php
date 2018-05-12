<?php

namespace Itstructure\RbacModule\components;

use Yii;
use yii\base\{Component, InvalidConfigException};
use yii\rbac\ManagerInterface;
use Itstructure\RbacModule\{
    interfaces\ModelInterface,
    interfaces\ValidateComponentInterface
};

/**
 * Class RbacValidateComponent
 * Component class for RBAC.
 *
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\RbacModule\components
 */
class RbacValidateComponent extends Component implements ValidateComponentInterface
{
    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $authManager;

    /**
     * Initialize.
     */
    public function init()
    {
        if (null === $this->authManager){
            $this->setAuthManager(Yii::$app->authManager);
        }

        if (null === $this->authManager){
            throw new InvalidConfigException('The authManager is not defined.');
        }
    }

    /**
     * Returns the authManager (RBAC).
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Set authManager (RBAC).
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager): void
    {
        $this->authManager = $authManager;
    }

    /**
     * Sets Rbac model.
     *
     * @param ModelInterface $model
     *
     * @return ModelInterface
     */
    public function setModel(ModelInterface $model): ModelInterface
    {
        $model->setAuthManager($this->authManager);

        return $model;
    }
}
