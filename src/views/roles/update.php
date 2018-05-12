<?php

use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Role */

$this->title = Module::t('roles', 'Update role') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('roles', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Module::t('main', 'Update');
?>
<div class="role-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
