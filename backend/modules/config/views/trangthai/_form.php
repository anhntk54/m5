<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Trangthai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trangthai-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
    <label class="radio-inline"><input type="radio" checked="checked" id="radio_select" name="optradio">Thuộc tính có sãn</label>
    <label class="radio-inline"><input type="radio" name="optradio" id="radio_input">Thuộc tính mới</label>
    <?= $form->field($model, 'type', ['options' => ['id' => 'input_text','style'=>'display:none;']])->textInput(['maxlength' => true]) ?>
    <?=
            $form->field($model, 'type_select', ['options' => ['id' => 'input_select']])
            ->dropDownList($types, ["class" => "form-control", "prompt" => "Kiểu",'id'=>'select_type']
            )
    ?>
    <?= $form->field($model, 'thuoc_tinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mo_ta')->textarea(['rows' => 6]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    var valueselect = "<?= $model->type ?>";
    $('#radio_input').change(function () {
        if ($(this).prop("checked")) {
            $('#input_text').show();
            $('#input_select').hide();
            $('#select_type').val("")
        }
    });
    $('#radio_select').change(function () {
        if ($(this).prop("checked")) {
            $('#input_text').hide();
            $('#input_select').show();
            $('#select_type').val(valueselect);
        }
    });
</script>