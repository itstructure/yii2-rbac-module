<?php

use yii\helpers\{Html, Url};
use yii\widgets\DetailView;
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\models\Permission;

/* @var $this yii\web\View */
/* @var $model Permission */

$this->title = Module::t('permissions', 'Permission') . ': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('permissions', 'Permissions'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-view">

    <p>
        <?php echo Html::a(Module::t('main', 'Update'), [
            $this->params['urlPrefix'].'update',
            'id' => $model->name
        ], [
            'class' => 'btn btn-primary'
        ]) ?>

        <?php echo Html::a(Module::t('main', 'Delete'), [
            $this->params['urlPrefix'].'delete',
            'id' => $model->name
        ], [
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
                    [
                        'label' => Module::t('roles', 'Permissions'),
                        'value' => function($model) {

                            $permissions = $model->permissions;

                            if (empty($permissions)) {return Module::t('roles', 'No permissions');}

                            return implode('<br>', array_map(function ($data) {

                                return Html::a($data, Url::to([
                                    '/'.$this->params['urlPrefix'].'view',
                                    'id' => $data
                                ]),
                                    [
                                        'target' => '_blank'
                                    ]);

                            }, $permissions));
                        },
                        'format' => 'raw'
                    ],
                ],
            ]); ?>

        </div>
    </div>

</div>
