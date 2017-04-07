<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogsMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_id') ?>

    <?= $form->field($model, 'table_name') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'ip_address') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
