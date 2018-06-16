<?php

use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Role */

$this->title = Module::t('roles', 'Create role');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('roles', 'Roles'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
