<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'display_name')->textInput() ?>
    <?= $form->field($model, 'password')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'mobile')->textInput() ?>
    <?= $form->field($model, 'card_id')->textInput() ?>
    <?= $form->field($model, 'bank_code')->textInput() ?>
    <?= $form->field($model, 'bank_name')->textInput() ?>
    <?= $form->field($model, 'bank_agency')->textInput() ?>
    <?=
            $form->field($model, 'status')
            ->dropDownList($model->getStatus(), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọn quyền người dùng"]
            )
    ?>
    <?=
            $form->field($model, 'role_id')
            ->dropDownList($model->getRoles(), ["class" => "form-control thanhpho_id", 'id' => "role_id", "prompt" => "Chọn quyền người dùng"]
            )
    ?>
    <?= $form->field($model, 'count_role')->textInput(['id' => 'count_role']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    jQuery(document).ready(function($) {
        if ($('#role_id').val() == 2) {
            $('#count_role').parent().show();
            
        }else{
            $('#count_role').val(0);
            $('#count_role').parent().hide();
        }
    });
    $('#role_id').change(function () {
        if ($(this).val() == 2) {
            $('#count_role').val(1);
            $('#count_role').parent().show();
            
        }else{
            $('#count_role').val(0);
            $('#count_role').parent().hide();
        }
    });
</script>