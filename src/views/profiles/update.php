<?php

use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\ProfileValidate */
/* @var $roles yii\rbac\Role[] */

$this->title = Module::t('profiles', 'Update profile') . ': ' . $model->userName;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('profiles', 'Profiles'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->userName,
    'url' => [
        $this->params['urlPrefix'].'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = Module::t('main', 'Update');
?>
<div class="profile-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>
