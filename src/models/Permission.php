<?php

namespace Itstructure\RbacModule\models;

use yii\helpers\ArrayHelper;
use yii\rbac\{Item, Permission as BasePermission, ManagerInterface};
use Itstructure\RbacModule\interfaces\ModelInterface;

/**
 * Class Permission
 *
 * @property BasePermission $permission
 * @property array $permissions
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\RbacModule\models
 */
class Permission extends Rbac implements ModelInterface
{
    /**
     * Permission object.
     *
     * @var BasePermission
     */
    public $permission;

    /**
     * Child permissions.
     *
     * @var array
     */
    public $permissions = [];

    /**
     * Validate rules.
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [
                    [
                        'permissions',
                    ],
                    'safe',
                ],
            ]
        );
    }

    /**
     * Get current child permissions assigned to current permission.
     *
     * @return \yii\rbac\Permission[]
     */
    protected function getCurrentChildren(): array
    {
        $permissions = $this->authManager->getChildren($this->getOldName());

        return array_keys($permissions);
    }

    /**
     * Get new child items.
     *
     * @return array
     */
    protected function getNewChildren(): array
    {
        return empty($this->permissions) ? [] : $this->permissions;
    }

    /**
     * Create new Permission.
     *
     * @param string $name
     *
     * @return Item
     */
    protected function createItem(string $name): Item
    {
        return $this->authManager->createPermission($name);
    }

    /**
     * Create self child permission.
     *
     * @param string $name
     *
     * @return Item
     */
    protected function createChild(string $name): Item
    {
        return $this->authManager->createPermission($name);
    }

    /**
     * Returns old name in current object, which is set before new value.
     *
     * @return mixed
     */
    protected function getOldName()
    {
        return null === $this->permission ? null : $this->permission->name;
    }

    /**
     * Returns Permission object.
     *
     * @param string $key
     *
     * @return Item|null
     */
    protected function getItem(string $key)
    {
        return $this->authManager->getPermission($key);
    }

    /**
     * Set permission field for child instance of Rbac - Permission.
     *
     * @param Rbac $instance
     * @param Item      $item
     *
     * @return Rbac
     */
    protected function setItemForInstance(Rbac $instance, Item $item): Rbac
    {
        $instance->permission = $item;
        return $instance;
    }

    /**
     * Set children permissions for instance of Role.
     *
     * @param Rbac $instance
     *
     * @return Rbac
     */
    protected function setChildrenForInstance(Rbac $instance): Rbac
    {
        $instance->permissions = $instance->getCurrentChildren();
        return $instance;
    }
}
