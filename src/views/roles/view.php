<?php

use yii\helpers\{Html, Url};
use yii\widgets\DetailView;
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\models\Role;

/* @var $this yii\web\View */
/* @var $model Role */

$this->title = Module::t('roles', 'Role') . ': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Roles',
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">

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
                        'label' => Module::t('roles', 'Name')
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Module::t('roles', 'Description')
                    ],
                    [
                        'label' => Module::t('roles', 'Permissions'),
                        'value' => function($model) {

                            $permissions = $model->permissions;

                            if (empty($permissions)) {return Module::t('roles', 'No permissions');}

                            return implode('<br>', array_map(function ($data) {

                                return Html::a($data, Url::to([
                                    '/'.$this->params['urlPrefixNeighbor'].'view',
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
