<?php

use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Permission */

$this->title = Module::t('permissions', 'Create permission');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('permissions', 'Permissions'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
