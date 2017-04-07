<?php


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\posts\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tất cả bài viết';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=\backend\modules\posts\components\FilerIndexWidgets::widget([
        'title'=>$this->title,'dataList'=>$dataList,
        'filer'=>$filer,'type'=>$type,
        'linkAjax'=>$linkAjax,'arrTitle'=>$arrTitle]); ?>
<div class="posts-index gridview">
    
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'class' => 'yii\grid\CheckboxColumn',],
            [
                'attribute' => 'title',
                'headerOptions' => ['style' => 'max-width: 50px'],
                'contentOptions' => ['style' => 'width: 300px;']
            ],
            'author_id' => [
                'label' => "Người đăng",
                'value' => function($data) {
                    return $data->author != NULL ? $data->author->username : "";
                }
            ],
            'categoty' => [
                'attribute' => 'category_id',
                'label' => "Danh mục",
                'value' => function($data) {
                    return $data->getStringCategories();
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map(\backend\modules\posts\models\Category::find()->where(['type'=>'posts'])->all(), 'id', 'title'), ['class' => 'form-control', 'prompt' => 'Tất cả']),
            ],
            'tags' => [
                'label' => "Tags",
                'value' => function($data) {
                    return $data->getStringTags();
                },
            ],
            // 'post_order',
            // 'create_at',
            // 'update_at',
            // 'slug',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            
            ],
        ],
    ]);
    ?>

</div>
