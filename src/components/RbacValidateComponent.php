<?php

namespace Itstructure\RbacModule\components;

use yii\base\{Model, InvalidConfigException};
use Itstructure\RbacModule\{
    interfaces\ModelInterface,
    interfaces\ValidateComponentInterface
};

/**
 * Class RbacValidateComponent
 * Component class for RBAC.
 *
 * @package Itstructure\RbacModule\components
 */
class RbacValidateComponent extends BaseValidateComponent implements ValidateComponentInterface
{
    /**
     * Sets Rbac model.
     *
     * @param Model $model
     *
     * @throws InvalidConfigException
     *
     * @return ModelInterface
     */
    public function setModel(Model $model): ModelInterface
    {
        if (!($model instanceof ModelInterface)) {

            $modelClass = (new\ReflectionClass($model));

            throw new InvalidConfigException($modelClass->getNamespaceName() .
                '\\' . $modelClass->getShortName().' class  must be implemented from 
                Itstructure\RbacModule\interfaces\ModelInterface.');
        }

        $model->setAuthManager($this->authManager);

        return $model;
    }
}
