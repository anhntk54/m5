<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\config\models\Banner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Chỉnh sửa';
?>
<div class="banner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
