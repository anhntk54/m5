<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Cron;
use common\models\CronJob;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Cron */

$this->title = "Thực thi cron " . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date_end',
            'status' => [
                'attribute' => 'status',
                'value' => Cron::getTextStatus()[$model->status],
            ],
        ],
    ])
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'table_id',
            'table_name',
            'status' => [
                'attribute' => 'status',
                'value' => function($data) {
                    return CronJob::getTextStatus()[$data->status];
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'controller' => 'cronjob',
            ],
        ],
    ]);
    ?>

</div>
