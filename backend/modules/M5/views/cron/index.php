<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Cron;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CronSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Crons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status'=>[
                'attribute'=>'status',
                'value'=>  function ($data){
                    return Cron::getTextStatus()[$data->status];
                }
            ],
            'date_end',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',],
        ],
    ]); ?>

</div>
