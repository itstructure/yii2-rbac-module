<?php

namespace Itstructure\RbacModule\components;

use Yii;
use yii\base\{Component, InvalidConfigException};
use yii\rbac\ManagerInterface;

/**
 * Class BaseValidateComponent
 *
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\RbacModule\components
 */
class BaseValidateComponent extends Component
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
}
