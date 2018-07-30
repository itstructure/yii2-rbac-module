<?php

namespace Itstructure\RbacModule\components;

use Yii;
use yii\base\{Model, InvalidConfigException};
use Itstructure\RbacModule\{
    interfaces\ModelInterface,
    interfaces\ValidateComponentInterface,
    models\ProfileValidate
};

/**
 * Class ProfileValidateComponent
 * Component class for validation user fields.
 *
 * @package Itstructure\RbacModule\components
 */
class ProfileValidateComponent extends BaseValidateComponent implements ValidateComponentInterface
{
    /**
     * Set a user model for ProfileValidateComponent validation model.
     *
     * @param Model $model
     *
     * @throws InvalidConfigException
     *
     * @return ModelInterface
     */
    public function setModel(Model $model): ModelInterface
    {
        /** @var ModelInterface $object */
        $object = Yii::createObject([
            'class' => ProfileValidate::class,
            'profileModel' => $model,
            'authManager' => $this->authManager,
        ]);

        return $object;
    }
}
