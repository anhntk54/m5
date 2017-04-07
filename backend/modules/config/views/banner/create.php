<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\config\models\Banner */

$this->title = 'Tạo Banner';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
