<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Member;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pin */
/* @var $form yii\widgets\ActiveForm */
//$this->registerJsFile(Yii::getAlias("@web") . '/js/select2/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerCssFile(Yii::getAlias("@web") . '/js/select2/css/select2.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<h1>Cấp người dùng mã pin</h1>
<div class="pin-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model,[
                    'class'=>'alert alert-danger alert-dismissible fade in',
                ]); ?>
    <?=
            $form->field($model, 'member_id')
            ->dropDownList(
                    ArrayHelper::map(Member::find()->where(['parent_id'=>  \Yii::$app->user->id])->all(), "id", "username"), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọn người dùng"]
            );
    ?>
    <?= $form->field($model, 'count_code')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".thanhpho_id").select2({});
    });
</script>