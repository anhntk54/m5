<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Member;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pin */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Tạo người dùng nhận tiền";
$this->registerJsFile(Yii::getAlias("@web") . '/js/select2/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::getAlias("@web") . '/js/select2/css/select2.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="pin-form">
    <div class="col-lg-12">
        <?php if (Yii::$app->session->hasFlash('log')): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('log') ?>
            </div>
        <?php endif; ?>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <p>Những người dùng bạn chọn có thể nhận tiền khi trò chơi bắt đầu</p>
    <?= $form->field($model, 'is_take')->radioList(array('2' => 'Chọn', 1 => 'Bỏ chọn')); ?>

    <?=
            $form->field($model, 'member_id')
            ->dropDownList(
                    ArrayHelper::map(Member::find()->all(), "id", "username"), ["class" => "form-control thanhpho_id", 'id' => "thanhp_id", "prompt" => "Chọn người dùng", 'multiple' => 'multiple']
            )
    ?>
    <div class="form-group">
        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".thanhpho_id").select2({placeholder: "Chọn người dùng"});
    });
</script>