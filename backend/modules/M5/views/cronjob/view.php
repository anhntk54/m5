<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CronJob;
/* @var $this yii\web\View */
/* @var $model common\models\CronJob */

$this->title = "Thực thi cronjob ".$model->id;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-job-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'table_id',
            'table_name',
            'status'=>[
                'attribute'=>'status',
                'value'=> CronJob::getTextStatus()[$model->status]
            ],
            'date_end',
        ],
    ]) ?>

</div>
