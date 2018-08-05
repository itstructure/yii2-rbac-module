<?php

use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Html};
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $form ActiveForm */
/* @var $model Itstructure\RbacModule\models\Permission */
?>

<div class="permission-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true])
                ->label(Module::t('permissions', 'Name')) ?>

            <?php echo $form->field($model, 'description')->textInput(['maxlength' => true])
                ->label(Module::t('permissions', 'Description')) ?>

            <?php echo $form->field($model, 'permissions')->checkboxList(
                ArrayHelper::map($model->filterChlidrenBeforeAdd($model->authManager->getPermissions()), 'name', 'name'),
                [
                    'separator' => '<br />'
                ]
            )->label(Module::t('permissions', 'Possible child permissions (not required)')); ?>

        </div>
    </div>


    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
