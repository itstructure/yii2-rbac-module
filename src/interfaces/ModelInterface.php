<?php

namespace Itstructure\RbacModule\interfaces;

use yii\rbac\ManagerInterface;

/**
 * Interface ModelInterface
 *
 * @package Itstructure\RbacModule\interfaces
 */
interface ModelInterface
{
    /**
     * Save data.
     *
     * @return bool
     */
    public function save();

    /**
     * Returns current model id.
     *
     * @return int|string
     */
    public function getId();

    /**
     * Load data.
     * Used from the parent model yii\base\Model.
     *
     * @param $data
     * @param null $formName
     *
     * @return bool
     */
    public function load($data, $formName = null);

    /**
     * Set auth manager.
     *
     * @param ManagerInterface $authManager
     */
    public function setAuthManager(ManagerInterface $authManager);

    /**
     * Get auth manager.
     *
     * @return ManagerInterface
     */
    public function getAuthManager(): ManagerInterface;

    /**
     * Sets the attribute values in a massive way.
     * Used from the parent model yii\base\Model.
     *
     * @param array $values attribute values (name => value) to be assigned to the model.
     * @param bool $safeOnly whether the assignments should only be done to the safe attributes.
     */
    public function setAttributes($values, $safeOnly = true);
}
