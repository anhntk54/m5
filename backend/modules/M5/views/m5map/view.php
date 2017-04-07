<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\M5Map;
use common\models\Report;

/* @var $this yii\web\View */
/* @var $model common\models\M5Map */

$this->title = "Chi tiết giao dịch" . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'M5 Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m5-map-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php if($model->isNotRunCron()) echo Html::a(Yii::t('app', 'Action'), ['run', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Bạn muốn thực hiện chức năng này?'),
                'method' => 'post',
            ],
        ]); ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'member_id' => [
                'attribute' => 'member_id',
                'value' => $model->membertake ? $model->membertake->username : "",
            ],
            'member_action' => [
                'attribute' => 'member_action',
                'value' => $model->membergive ? $model->membergive->username : "",
            ],
            'money',
            'status' => [
                'attribute' => 'status',
                'value' => $model->getStatusText()
            ],
            'result' => [
                'attribute' => 'result',
                'value' => M5Map::getTextResult()[$model->result]
            ],
            'viewed' => [
                'attribute' => 'viewed',
                'value' => M5Map::getTextViews()[$model->viewed]
            ],
            'cronjob_id' => [
                'attribute' => 'cronjob_id',
                'value' => $model->getCronText()
            ],
            'date_end' => [
                'attribute' => 'date_end',
                'value' => $model->getTimeEnd()
            ]
        ],
    ])
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'member_id' => [
                'attribute' => 'member_id',
                'value' => function($data) {
                    return $data->member != NULL ? $data->member->username : "";
                }
            ],
            'result' => [
                'attribute' => 'result',
                'value' => function($data) {
                    return Report::getTextResult()[$data->result];
                },
                'filter' => Html::activeDropDownList($searchModel, 'result', Report ::getTextResult(), ['class' => 'form-control', 'prompt' => 'Kết quả']),
            ],
            'type' => [
                'attribute' => 'type',
                'value' => function($data) {
                    return Report::getTypes()[$data->type];
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', Report::getTypes(), ['class' => 'form-control', 'prompt' => 'Report Type']),
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '',
                'controller' => 'report',
            ],
        ],
    ]);
    ?>

</div>
