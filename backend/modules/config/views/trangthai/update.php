<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Trangthai */

$this->title = $model->ten;
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trangthai-update">

    <h1><?= Html::encode($this->title) ?></h1>
     <p>
        <?= Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    $this->render('_form', [
        'model' => $model,
        'types' => $types,
    ])
    ?>

</div>
