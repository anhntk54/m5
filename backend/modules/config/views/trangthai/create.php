<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Trangthai */

$this->title = 'Tạo thuộc tính mới';
$this->params['breadcrumbs'][] = ['label' => 'Tất cả', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trangthai-create">

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
