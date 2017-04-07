<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\M5;
use common\models\M5Map;

/* @var $this yii\web\View */
/* @var $model common\models\M5 */

$this->title = "Chi tiết giao dịch " . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'M5s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m5-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= backend\modules\M5\components\CreateMemberTakeWidgets::widget(['model'=>$model]) ?>
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
            'id',
            'member_id' => [
                'label' => "Người tạo",
                'attribute' => 'member_id',
                'value' => $model->member ? $model->member->username : "",
            ],
            'type' => [
                'attribute' => 'type',
                'value' => M5::getTypes()[$model->type],
            ],
            'money',
            'money_current',
            'status' => [
                'attribute' => 'status',
                'value' => $model->getStatus(),
            ],
            'date' => [
                'attribute' => 'date',
                'value' => $model->getTimeEnd(),
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
            'member_id' => [
                'label' => "Người giao dịch",
                'attribute' => 'member_id',
                'value' => function($data) {
                    return Yii::$app->request->get('id') == $data->m5_take_id ? $data->membergive->username : $data->membertake->username;
                }
            ],
            'money',
            'status' => [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatusText();
                }
            ],
            'cronjob_id' => [
                'attribute' => 'cronjob_id',
                'value' => function($data) {
                    return $data->getCronText();
                }
            ],
            'date' => [
                'attribute' => 'date',
                'value' => function($data) {
                    return $data->getTimeEnd();
                }
            ],
            'result' => [
                'attribute' => 'result',
                'value' => function($data) {
                    return M5Map::getTextResult()[$data->result];
                },
                'filter' => Html::activeDropDownList($searchModel, 'result', M5Map ::getTextResult(), ['class' => 'form-control', 'prompt' => 'Kết quả']),
            ],
            'viewed' => [
                'attribute' => 'viewed',
                'value' => function($data) {
                    return M5Map::getTextViews()[$data->viewed];
                },
                'filter' => Html::activeDropDownList($searchModel, 'viewed', M5Map ::getTextViews(), ['class' => 'form-control', 'prompt' => 'Loại hiển thị']),
            ],
            // 'create_at',
            // 'date_end',
            // 'date_status',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'controller' => 'm5map',
            ],
        ],
    ]);
    ?>

</div>
