<?php

namespace Itstructure\RbacModule\interfaces;

use yii\db\ActiveRecordInterface;
use yii\web\IdentityInterface;
use yii\rbac\Role as BaseRole;

/**
 * Interface RbacIdentityInterface
 *
 * @package Itstructure\RbacModule\interfaces
 */
interface RbacIdentityInterface extends ActiveRecordInterface, IdentityInterface
{
    /**
     * Get user name.
     *
     * @return string
     */
    public function getUserName(): string ;

    /**
     * List of profile assigned roles.
     *
     * @return BaseRole[]
     */
    public function getRoles();
}
