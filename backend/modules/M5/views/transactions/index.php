<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?=\backend\modules\posts\components\FilerIndexWidgets::widget([
        'title'=>$this->title,'dataList'=>$dataList,
        'filer'=>$filer,'type'=>$type,
        'linkAjax'=>$linkAjax,'arrTitle'=>$arrTitle]); ?>
<div class="transactions-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'class' => 'yii\grid\CheckboxColumn',],

            'id',
            'member_id' => [
                'label' => "Người giao dịch",
                'attribute' => 'member_id',
                'value' => function($data) {
                    return $data->member != NULL ? $data->member->username : "";
                }
            ],
            'member_action' => [
                'label' => "Người thực hiện",
                'attribute' => 'member_action',
                'value' => function($data) {
                    return $data->memberaction != NULL ? $data->memberaction->username : "Admin";
                }
            ],
            'count',
            'money',
            'status' => [
                'label' => "Trạng thái",
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->status != 0 ? "Kết thúc" : "Chưa thực thi";
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
            ],
                    
        ],
    ]); ?>

</div>
