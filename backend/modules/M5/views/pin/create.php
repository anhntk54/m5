<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pin */

$this->title = 'Create Pin';
$this->params['breadcrumbs'][] = ['label' => 'Pins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
