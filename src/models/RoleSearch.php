<?php

namespace Itstructure\RbacModule\models;

use yii\data\ArrayDataProvider;

/**
 * Class RoleSearch
 *
 * @package Itstructure\RbacModule\models
 */
class RoleSearch extends Role
{
    /**
     * Modify for custom search rules.
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * Creates data provider
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $allModels = $this->authManager->getRoles();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $allModels,
        ]);

        /**
         * Modify for custom search conditions.
         *
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }*/

        return $dataProvider;
    }
}
