<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Role */

$this->title = Module::t('roles', 'Role') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">

    <p>
        <?php echo Html::a(Module::t('main', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Module::t('main', 'Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('main', 'Are you sure you want to do this action?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-4">

            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'name',
                        'label' => Module::t('roles', 'Name')
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Module::t('roles', 'Description')
                    ],
                ],
            ]); ?>

        </div>
    </div>

</div>
