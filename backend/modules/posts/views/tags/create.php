<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Tags */

$this->title = 'Tạo từ khóa mới';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
