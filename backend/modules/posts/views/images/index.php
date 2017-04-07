<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\posts\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả hình ảnh';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=\backend\modules\posts\components\FilerIndexWidgets::widget([
    'title'=>$this->title,'filer'=>5,
    'table'=> backend\modules\posts\models\Images::tableName(),
    'dataList'=>$dataList,
    'linkAjax'=>$linkAjax]); ?>
<div class="images-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'class' => 'yii\grid\CheckboxColumn',],

            'id',
            [
                'attribute'=>'url',
                'format'=>'html',
                'value' => function($data) {
                    return Html::img($data->getUrl(),['width'=>'100']);
                }
            ],
            'title',
            'description:ntext',
            'alt',
            // 'create_at',
            // 'update_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
