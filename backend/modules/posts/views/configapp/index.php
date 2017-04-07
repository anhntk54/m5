<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Province;
$this->registerJsFile(Yii::getAlias("@web") . '/js/select2/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::getAlias("@web") . '/js/select2/css/select2.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Tags */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Cấu hình tổng quan";
?>
<h1><?= Html::encode("Cấu hình ") ?></h1>
<div class="tags-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'baseUrl')->textInput() ?>

    <?= $form->field($model, 'nameApp')->textInput(['maxlength' => true]) ?>
    <?=
            $form->field($model, 'tinh_id')
            ->dropDownList(
                    ArrayHelper::map(Province::find()->all(), "provinceid", "name"), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọn thành phố"]
            )->label(false)
    ?>
    <?=
            $form->field($model, 'huyen_id')
            ->dropDownList(ArrayHelper::map(\common\models\District::find()->where(['provinceid' => $model->tinh_id])->all(), "districtid", "name"), ["class" => "huyen_id col-md-6", 'id' => "huyeni_id", "prompt" => "Chọn huyện"]
            )->label(false)
    ?>
    <?=
            $form->field($model, 'xa_id')
            ->dropDownList(ArrayHelper::map(\common\models\Ward::find()->where(['districtid' => $model->huyen_id])->all(), "wardid", "name"), ["class" => "xa_id col-md-6", 'id' => "xai_id", "prompt" => "Chọn xã"]
            )->label(false)
    ?>

    <div class="form-group">
        <?= Html::submitButton("Chỉnh sửa", ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".thanhpho_id").select2();
        $(".huyen_id").select2();
        $(".xa_id").select2();
        $(".thanhpho_id").change(function () {
            var idt = $(this).val();
            $.ajax({
                url: "<?= yii\helpers\Url::to("?r=batdongsan/province/huyen"); ?>",
                type: "POST",
                data: {tinh: idt},
                success: function (data)
                {
                    $('.huyen_id').html(data);
                },
            });
        });
        $(".huyen_id").change(function () {
            var idt = $(this).val();
            console.log("change" + $(this).val());
            $.ajax({
                url: "<?= yii\helpers\Url::to("?r=batdongsan/province/xa"); ?>",
                type: "POST",
                dataType: "json",
                data: {tinh: idt},
                success: function (data)
                {
                    $('#batdongsan-diadiem').val(data.title);
                    $('.xa_id').html(data.html);
                },
            });
        });
        $(".xa_id").change(function () {
            var idt = $(this).val();
            console.log("change" + $(this).val());
            $.ajax({
                url: "<?= yii\helpers\Url::to("?r=batdongsan/province/chonxa"); ?>",
                type: "POST",
                dataType: "json",
                data: {tinh: idt},
                success: function (data)
                {
                    $('#batdongsan-diadiem').val(data.title);
                },
            });
        });
    });
</script>