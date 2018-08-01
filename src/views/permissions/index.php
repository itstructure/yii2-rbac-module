<?php

use yii\grid\GridView;
use yii\helpers\{Url, Html};
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\models\PermissionSearch;

/* @var $this yii\web\View */
/* @var $roles Itstructure\RbacModule\models\Permission */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $searchModel PermissionSearch */

$this->title = Module::t('permissions', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <p>
        <?php echo Html::a(Module::t('permissions', 'Create permission'), [
            $this->params['urlPrefix'].'create'
        ], [
            'class' => 'btn btn-success'
        ]) ?>
    </p>


    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'name' => [
                'label' => Module::t('permissions', 'Name'),
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
            'description' => [
                'label' => Module::t('permissions', 'Description'),
                'value' => function($item) {
                    return $item->description;
                },
                'format' => 'raw',
            ],
            'permissions' => [
                'label' => Module::t('permissions', 'Permissions'),
                'value' => function($item) use ($searchModel) {

                    /* @var $searchModel PermissionSearch */
                    $permissions = $searchModel->authManager->getChildren($item->name);

                    if (empty($permissions)) {return Module::t('permissions', 'No permissions');}

                    return implode('<br>', array_map(function ($data) {

                        return Html::a($data->name, Url::to([
                            '/'.$this->params['urlPrefix'].'view',
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
                'urlCreator'=>function($action, $model, $key, $index){
                    return Url::to([
                        $this->params['urlPrefix'].$action,
                        'id' => $model->name
                    ]);
                }
            ],
        ],
    ]); ?>

</div>
