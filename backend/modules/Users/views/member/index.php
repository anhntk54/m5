<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<?=\backend\modules\posts\components\FilerIndexWidgets::widget([
        'title'=>$this->title,'dataList'=>$dataList,
        'filer'=>$filer,'type'=>$type,
        'linkAjax'=>$linkAjax,'arrTitle'=>$arrTitle]); ?>
<div class="member-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           [ 'class' => 'yii\grid\CheckboxColumn',],

            'id',
            'username',
            'parent_id',
            'mobile',
            'password',
            // 'password_hash',
            // 'password_reset_token',
            // 'email:email',
            // 'auth_key',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'role_id',
            // 'key_member',
            // 'level_id',
            // 'bank_code',
            // 'bank_name',
            // 'bank_agency',
            // 'card_id',

            ['class' => 'yii\grid\ActionColumn','template' => '{update}{delete}',],
            
        ],
    ]); ?>

</div>
