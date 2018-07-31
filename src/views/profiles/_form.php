<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\FieldWidgets\{Fields, FieldType};
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\ProfileValidate */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles yii\rbac\Role[] */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo Fields::widget([
                    'fields' => [
                        [
                            'name' => 'roles',
                            'type' => FieldType::FIELD_TYPE_CHECKBOX,
                            'data' => ArrayHelper::map($roles, 'name', 'name'),
                            'label' => Module::t('profiles', 'Roles')
                        ]
                    ],
                    'model' => $model,
                    'form'  => $form,
                ]) ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton(Module::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
