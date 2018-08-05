<?php

namespace Itstructure\RbacModule\models;

use Yii;
use yii\base\{Model, InvalidConfigException};
use yii\rbac\{Item, ManagerInterface};
use Itstructure\RbacModule\Module;

/**
 * Class Rbac
 * Model Rbac to work with roles and permissions.
 *
 * @property string $name
 * @property string $description
 * @property ManagerInterface $authManager
 *
 * @package Itstructure\RbacModule\models
 */
abstract class Rbac extends Model
{
    /**
     * Role name.
     *
     * @var string
     */
    public $name;

    /**
     * Role description.
     *
     * @var string
     */
    public $description;

    /**
     * Auth manager.
     *
     * @var ManagerInterface
     */
    private $authManager;

    /**
     * Create new item (Role or permission).
     *
     * @param string $name
     *
     * @return Item
     */
    abstract protected function createItem(string $name): Item;

    /**
     * Create child item.
     * Example: parent - role, child - permission.
     *
     * @param string $name
     *
     * @return Item
     */
    abstract protected function createChild(string $name): Item;

    /**
     * Get current child items.
     *
     * @return array
     */
    abstract protected function getCurrentChildren(): array ;

    /**
     * Get new child items.
     *
     * @return array
     */
    abstract protected function getNewChildren(): array ;

    /**
     * Returns old name in current object, which is set before new value.
     *
     * @return mixed
     */
    abstract protected function getOldName();

    /**
     * Returns item object: Role or Permission.
     *
     * @param string $key
     *
     * @return Item|null
     */
    abstract protected function getItem(string $key);

    /**
     * Set item (role or permission) for instance of Rbac.
     *
     * @param Rbac $instance
     * @param Item      $item
     *
     * @return Rbac
     */
    abstract protected function setItemForInstance(Rbac $instance, Item $item): Rbac;

    /**
     * Set children for instance of Rbac (for Role or Permission).
     *
     * @param Rbac $instance
     *
     * @return Rbac
     */
    abstract protected function setChildrenForInstance(Rbac $instance): Rbac;

    /**
     * Initialize.
     */
    public function init()
    {
        if (null === $this->authManager) {
            $this->setAuthManager(Yii::$app->authManager);
        }

        if (null === $this->authManager) {
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
                [
                    'name',
                    'description',
                ],
                'required',
            ],
            [
                [
                    'name',
                ],
                'string',
                'min' => 3,
                'max' => 64,
            ],
            [
                'name',
                'match',
                'pattern' => '/^[a-z]\w*$/i',
                'message' => Module::t('rbac', 'Name must contain latin symbols and numeric without spaces.')
            ],
            [
                [
                    'description',
                ],
                'string',
            ],
            [
                [
                    'name',
                ],
                'checkNameForUnique',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Set auth manager.
     *
     * @param ManagerInterface $authManager
     *
     * @return $this
     */
    public function setAuthManager(ManagerInterface $authManager)
    {
        $this->authManager = $authManager;
        return $this;
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
     * @param string $key
     *
     * @return static
     */
    public function findOne(string $key)
    {
        $item = $this->getItem($key);

        $instance = new static();
        $instance->name = $item->name;
        $instance->description = $item->description;

        return $this->setChildrenForInstance($this->setItemForInstance($instance, $item));
    }

    /**
     * Save item data.
     *
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $item = $this->createItem($this->name);
        $item->description = $this->description;

        if ($this->checkForNewRecord()) {
            return $this->createData($item);
        } else {
            return $this->updateData($item);
        }
    }

    /**
     * Returns current model id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->name;
    }

    /**
     * Delete current role.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return $this->authManager->remove($this->createItem($this->name));
    }

    /**
     * Delete from general list children items, which can't be assigned to parent.
     *
     * @param array $chlidren
     *
     * @return array
     */
    public function filterChlidrenBeforeAdd(array $chlidren): array
    {
        if (null === $this->getOldName()) {
            return $chlidren;
        }

        foreach ($chlidren as $key => $value) {

            $parent = $this->createItem($this->getOldName());

            $child = $this->createChild($key);

            if (!$this->authManager->canAddChild($parent, $child)) {
                unset($chlidren[$key]);
            }
        }

        return $chlidren;
    }

    /**
     * Check name for unique.
     *
     * @param $attribute
     *
     * @return bool
     */
    public function checkNameForUnique($attribute): bool
    {
        $item = $this->getItem($this->name);

        if (null !== $item && $this->getOldName() !== $item->name) {
            $this->addError($attribute, Module::t('rbac', 'This name already exists.'));
            return false;
        }

        return true;
    }

    /**
     * Check if current model is new record.
     * Return true if there is a new record.
     *
     * @return bool
     */
    private function checkForNewRecord(): bool
    {
        return null === $this->getOldName();
    }

    /**
     * Function for creating record.
     *
     * @param Item $item
     *
     * @return bool
     */
    private function createData(Item $item): bool
    {
        if (!$this->authManager->add($item)) {
            return false;
        }

        $newChildren = $this->getNewChildren();

        if (count($newChildren) > 0) {
            $this->addChildren($newChildren);
        }

        return true;
    }

    /**
     * Function for updating record.
     *
     * @param Item $item
     *
     * @return bool
     */
    private function updateData(Item $item): bool
    {
        if (!$this->authManager->update($this->getOldName(), $item)) {
            return false;
        }

        $this->authManager->removeChildren($item);

        $newChildren = $this->getNewChildren();

        if (count($newChildren) > 0) {
            $this->addChildren($newChildren);
        }

        return true;
    }

    /**
     * Add childs items for parent item.
     *
     * @param array $childs
     */
    private function addChildren(array $childs): void
    {
        foreach ($childs as $child) {

            $this->authManager->addChild(
                $this->createItem($this->name),
                $this->createChild($child)
            );
        }
    }
}
