<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\M5\models\LogsMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'table_id',
            'table_name',
            'member_id'=>[
                'attribute' => 'member_id',
                    'value'=>function ($data){
                        return $data->member ? $data->member->username : '';
                    }
            ],
            'created_at',
             'value',
             'ip_address',
        ],
    ]); ?>

</div>
