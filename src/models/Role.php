<?php

namespace Itstructure\RbacModule\models;

use yii\helpers\ArrayHelper;
use yii\rbac\{Item, Role as BaseRole, ManagerInterface};
use Itstructure\RbacModule\interfaces\ModelInterface;
use Itstructure\RbacModule\Module;

/**
 * Class Role
 *
 * @property BaseRole $role
 * @property array $permissions
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\RbacModule\models
 */
class Role extends Rbac implements ModelInterface
{
    /**
     * Role object.
     *
     * @var BaseRole
     */
    public $role;

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
                    'required',
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('roles', 'Name'),
            'description' => Module::t('roles', 'Description'),
            'permissions' => Module::t('roles', 'Permissions'),
        ];
    }

    /**
     * Get current child permissions assigned to current role.
     *
     * @return \yii\rbac\Permission[]
     */
    protected function getCurrentChildren(): array
    {
        $permissions = $this->authManager->getPermissionsByRole($this->getOldName());

        return array_keys($permissions);
    }

    /**
     * Get new child permissions.
     *
     * @return array
     */
    protected function getNewChildren(): array
    {
        return empty($this->permissions) ? [] : $this->permissions;
    }

    /**
     * Create new role.
     *
     * @param string $name
     *
     * @return Item
     */
    protected function createItem(string $name): Item
    {
        return $this->authManager->createRole($name);
    }

    /**
     * Create child permission.
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
        return null === $this->role ? null : $this->role->name;
    }

    /**
     * Returns role object.
     *
     * @param string $key
     *
     * @return Item|null
     */
    protected function getItem(string $key)
    {
        return $this->authManager->getRole($key);
    }

    /**
     * Set role field for child instance of Rbac - Role.
     *
     * @param Rbac $instance
     * @param Item      $item
     *
     * @return Rbac
     */
    protected function setItemForInstance(Rbac $instance, Item $item): Rbac
    {
        $instance->role = $item;
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
