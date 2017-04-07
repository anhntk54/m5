<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<div class="col-md-4">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Cập nhật bài viết</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <div class="col-md-12 no-padding">
                <div class="form-control col-md-2 no-border" style="width: 40%;padding-top: 16px;">
                    <p class="no-padding">Chế độ xem: </p>
                </div>
                <?=
                        $form->field($model, 'status')
                        ->dropDownList(ArrayHelper::map(\common\models\Trangthai::find()->where(['type' => 'status'])->all(), "id", "ten"), ["class" => "col-md-4 form-control", 'style' => "width: 50%;", "prompt" => "Chế độ xem"]
                        )->label(false)
                ?>
            </div>
        </div>

        <div class="box-header span12">
            <div class="col-md-4">
                <?php if (!$model->isNewRecord) { ?>

                <input type="button" name="delete" class="btn btn-danger" value="Xóa" onClick="confirmDelete('<?= $link ?>')">
                    <?php
                } else {
                    echo Html::a('Hủy', ['index'], ['class' => 'btn btn-danger']);
                }
                ?>
            </div>
            <div class="col-md-offset-8">
                <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Chỉnh sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<script>
    function confirmDelete(url) {
        if (confirm("Bạn có muốn xóa bài viết này?")) {
            window.location.href = url;
        } else {
            false;
        }
    }
</script>