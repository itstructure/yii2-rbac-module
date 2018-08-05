<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true])
                ->label(Module::t('roles', 'Name')) ?>

            <?php echo $form->field($model, 'description')->textInput(['maxlength' => true])
                ->label(Module::t('roles', 'Description')) ?>

            <?php echo $form->field($model, 'permissions')->checkboxList(
                ArrayHelper::map($model->filterChlidrenBeforeAdd($model->authManager->getPermissions()), 'name', 'name'),
                [
                    'separator' => '<br />'
                ]
            )->label(Module::t('roles', 'Permissions')); ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton(Module::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
