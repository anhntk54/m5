<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\posts\models\TrangthaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả thuộc tính';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trangthai-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ten',
            'type',
            'thuoc_tinh',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
