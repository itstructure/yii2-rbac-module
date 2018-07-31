<?php

use yii\grid\GridView;
use yii\helpers\{Html, Url};
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\interfaces\RbacIdentityInterface;

/* @var $this yii\web\View */
/* @var $searchModel RbacIdentityInterface */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('profiles', 'Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => Module::t('main', 'ID'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->id),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            [
                'label' => Module::t('profiles', 'Name'),
                'value' => function($searchModel) {
                    return Html::a(
                        Html::encode($searchModel->userName),
                        Url::to([
                            $this->params['urlPrefix'].'view',
                            'id' => $searchModel->id
                        ])
                    );
                },
                'format' => 'raw',
            ],
            [
                'label' => Module::t('profiles', 'Roles'),
                'value' => function($searchModel) {
                    /* @var $searchModel RbacIdentityInterface */
                    $roles = $searchModel->getRoles();

                    if (empty($roles)) {return Module::t('profiles', 'No roles');}

                    return implode('<br>', array_map(function ($data) {

                        return Html::a($data, Url::to([
                            '/'.$this->params['urlPrefix'].'view',
                            'id' => $data
                        ]),
                        [
                            'target' => '_blank'
                        ]);

                    }, array_keys($roles)));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'label' => Module::t('main', 'Created date'),
                'format' =>  ['date', 'dd.MM.YY HH:mm:ss'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => Module::t('main', 'Updated date'),
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Module::t('main', 'Actions'),
                'template' => '{view} {update} {delete}',
                'urlCreator'=>function($action, $model, $key, $index){
                    return Url::to([
                        $this->params['urlPrefix'].$action,
                        'id' => $model->id
                    ]);
                }
            ],
        ]
    ]); ?>
</div>
