<?php

namespace Itstructure\RbacModule\models;

use yii\rbac\{ManagerInterface, Role as BaseRole};
use yii\base\{Model, InvalidConfigException};
use Itstructure\RbacModule\interfaces\{ModelInterface, RbacIdentityInterface};

/**
 * Class for validation user(profile) roles.
 *
 * @property string $userUame
 * @property BaseRole[] $roles
 * @property RbacIdentityInterface $profileModel
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\UsersModule\models
 */
class ProfileValidate extends Model implements ModelInterface
{
    /**
     * Current profile (user) model.
     *
     * @var RbacIdentityInterface
     */
    private $profileModel;

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
            throw new InvalidConfigException('The authManager is not defined.');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'roles',
                'required',
            ],
            [
                'roles',
                'validateRoles',
            ],
        ];
    }

    /**
     * List if attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'roles',
        ];
    }

    /**
     * List if attribute labels.
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roles' => 'Roles',
        ];
    }

    /**
     * Get user name.
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->profileModel->getUserName();
    }

    /**
     * Set new roles values.
     *
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * List of profile assigned roles.
     *
     * @return string[]
     */
    public function getRoles()
    {
        return array_keys($this->profileModel->getRoles());
    }

    /**
     * Set profile (user) model.
     *
     * @param RbacIdentityInterface $model.
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function setProfileModel(RbacIdentityInterface $model): void
    {
        $this->profileModel = $model;
    }

    /**
     * Returns profile (user) model.
     *
     * @return RbacIdentityInterface
     */
    public function getProfileModel(): RbacIdentityInterface
    {
        return $this->profileModel;
    }

    /**
     * Set auth manager.
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Get auth manager.
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface
    {
        return $this->authManager;
    }

    /**
     * Validate roles data format.
     *
     * @param $attribute
     *
     * @return bool
     */
    public function validateRoles($attribute): bool
    {
        if (!is_array($this->roles)){
            $this->addError($attribute, 'Incorrect roles data format.');
            return false;
        }

        return true;
    }

    /**
     * Save user data.
     *
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()){
            return false;
        }

        $this->assignRoles();

        return true;
    }

    /**
     * Returns current model id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->profileModel->getId();
    }

    /**
     * Assign roles.
     *
     * @return void
     */
    private function assignRoles(): void
    {
        if (!$this->profileModel->getIsNewRecord()){
            $this->authManager->revokeAll(
                $this->profileModel->getId()
            );
        }

        foreach ($this->roles as $role){
            $roleObject = $this->authManager->getRole($role);

            if (null === $roleObject){
                continue;
            }

            $this->authManager->assign($roleObject, $this->profileModel->getId());
        }
    }
}
