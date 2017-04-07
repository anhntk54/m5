<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Level */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="level-form">
    <h2>Tạo giao dịch GD</h2>
    <?php $form = ActiveForm::begin(['action'=>['/M5/default/createtake']]); ?>
    <?=
            $form->field($value, 'member_id')
            ->dropDownList(ArrayHelper::map($list, 'id', 'username'), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọnngười dùng"]
            )->label(FALSE);
    ?>
    <?= $form->field($value, 'm5_id')->hiddenInput()->label(FALSE) ?>
    <div class="form-group">
        <?= Html::submitButton("Tạo giao dịch", ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
