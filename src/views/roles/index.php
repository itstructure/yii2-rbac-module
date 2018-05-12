<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use Itstructure\RbacModule\Module;

/* @var $this yii\web\View */
/* @var $roles Itstructure\RbacModule\models\Role */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = Module::t('roles', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <p>
        <?php echo Html::a(Module::t('roles', 'Create role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'name' => [
                'label' => Module::t('roles', 'Name'),
                'value' => function($item) {
                    return Html::a(
                        Html::encode($item->name),
                        Url::to([
                            'view', 'id' => $item->name
                        ])
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'description',
                'label' =>  Module::t('roles', 'Description'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Module::t('main', 'Actions'),
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
