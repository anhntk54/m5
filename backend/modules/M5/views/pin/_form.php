<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Member;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pin */
/* @var $form yii\widgets\ActiveForm */
list(, $url) = Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/select2');
$this->registerJsFile($url . '/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($url . '/select2.min.css');
?>

<div class="pin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
            $form->field($model, 'member_id')
            ->dropDownList(
                    ArrayHelper::map(Member::find()->where(['parent_id'=>0])->all(), "id", "username"), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọn người dùng"]
            )->label(false)
    ?>
    <?= $form->field($model, 'count_code')->textInput(['maxlength' => true]) ?>

     <?= Html::activeDropDownList($model, "status", $model->getStatus(),["class"=>"form-control","prompt"=>"Trạng thái code"]) ?>

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