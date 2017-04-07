<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'm5map_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'cron_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
