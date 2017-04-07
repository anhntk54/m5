<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Report;

/* @var $this yii\web\View */
/* @var $model common\models\Report */

$this->title = "Đề xuất ".$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view">

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
            'member_id' => [
                'attribute' => 'member_id',
                'value' => $model->member ? $model->member->username : "",
            ],
            'type' => [
                'attribute' => 'type',
                'value' => Report::getTypes()[$model->type],
            ],
            'cronjob_id',
            'result' => [
                'attribute' => 'result',
                'value' => Report::getTextResult()[$model->result],
            ],
            'type' => [
                'attribute' => 'type',
                'value' => Report::getTypes()[$model->type],
            ],
            'date_end'=>[
                'attribute'=>'date_end',
                'value'=>$model->getTimeEnd()
            ],
        ],
    ]) ?>

</div>
