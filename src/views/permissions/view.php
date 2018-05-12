<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $model Itstructure\RbacModule\models\Permission */

$this->title = Module::t('permissions', 'Permission') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('permissions', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-view">

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
                        'label' => Module::t('permissions', 'Name')
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Module::t('permissions', 'Description')
                    ],
                ],
            ]); ?>

        </div>
    </div>

</div>
