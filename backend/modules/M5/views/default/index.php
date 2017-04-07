<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\M5;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\M5Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tất cả giao dịch');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m5-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'class' => 'yii\grid\CheckboxColumn',],
            'id',
            'member_id' => [
                'label' => "Người tạo",
                'attribute' => 'member_id',
                'value' => function($data) {
                    return $data->member != NULL ? $data->member->username : "";
                }
            ],
            'type' => [
                'attribute' => 'type',
                'value' => function($data) {
                    return M5::getTypes()[$data->type];
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', M5::getTypes(), ['class' => 'form-control', 'prompt' => 'Loại giao dịch']),
            ],
            'money',
            'money_current',
            'status' => [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatus();
                }
            ],
            'date' => [
                'attribute' => 'date',
                'value' => function($data) {
                    return $data->getTimeEnd();
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',],
        ],
    ]);
    ?>

</div>
