<?php

use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Permission */

$this->title = Module::t('permissions', 'Update permission') . ': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('permissions', 'Permissions'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = Module::t('main', 'Update');
?>
<div class="permission-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
