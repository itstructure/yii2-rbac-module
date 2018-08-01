<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\models\RoleSearch;

/* @var $this yii\web\View */
/* @var $roles Itstructure\RbacModule\models\Role */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $searchModel RoleSearch */

$this->title = Module::t('roles', 'Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <p>
        <?php echo Html::a(Module::t('roles', 'Create role'), [
            $this->params['urlPrefix'].'create'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
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
                            $this->params['urlPrefix'].'view',
                            'id' => $item->name
                        ])
                    );
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'description',
                'label' =>  Module::t('roles', 'Description'),
            ],
            'permissions' => [
                'label' => Module::t('roles', 'Permissions'),
                'value' => function($item) use ($searchModel) {

                    /* @var $searchModel RoleSearch */
                    $permissions = $searchModel->authManager->getPermissionsByRole($item->name);

                    if (empty($permissions)) {return Module::t('roles', 'No permissions');}

                    return implode('<br>', array_map(function ($data) {

                        return Html::a($data->name, Url::to([
                            '/'.$this->params['urlPrefixNeighbor'].'view',
                            'id' => $data->name
                        ]),
                            [
                                'target' => '_blank'
                            ]);

                    }, $permissions));
                },
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Module::t('main', 'Actions'),
                'template' => '{view} {update} {delete}',
                'urlCreator' => function($action, $model, $key, $index){
                    return Url::to([
                        $this->params['urlPrefix'].$action,
                        'id' => $model->name
                    ]);
                }
            ],
        ],
    ]); ?>

</div>
