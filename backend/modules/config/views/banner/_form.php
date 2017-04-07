<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\config\models\Trangthai;
use \yii\helpers\ArrayHelper;
$this->registerJsFile(Yii::getAlias("@web") . '/js/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::getAlias("@web") . '/css/datepicker3.css');
/* @var $this yii\web\View */
/* @var $model backend\modules\config\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'url')->textarea(['rows' => 1]) ?>

                    <div class="col-md-12 form-group">
                        <label class="control-label" for="category-title">Ảnh</label>
                        <div class="col-md-4">
                            <?= \backend\modules\posts\components\SelectImageWidgets::widget(['model' => $model]) ?>
                        </div>
                    </div>
                    <div class="form-group  col-md-4 no-padding">
                        <?=
                                $form->field($model, 'position', ['options' => ['id' => 'input_select']])
                                ->dropDownList(ArrayHelper::map(Trangthai::find()->where(['type' => 'position_banner'])->all(), 'thuoc_tinh', 'ten'), ["class" => "form-control", "prompt" => "Vị trí banner", 'id' => 'select_type']
                                )
                        ?>
                    </div>
                    <div class="form-group  col-md-4">

                        <?=
                                $form->field($model, 'type', ['options' => ['id' => 'input_select']])
                                ->dropDownList(ArrayHelper::map(Trangthai::find()->where(['type' => 'type_banner'])->all(), 'thuoc_tinh', 'ten'), ["class" => "form-control"]
                                )
                        ?>
                    </div>
                    <div class="form-group  col-md-4 no-padding">
                        <?=
                                $form->field($model, 'new_tab', ['options' => ['id' => 'input_select']])
                                ->dropDownList(ArrayHelper::map(Trangthai::find()->where(['type' => 'open_new_tab'])->all(),'thuoc_tinh', 'ten'), ["class" => "form-control", 'id' => 'select_type']
                                )
                        ?>
                    </div>
                    <div class="form-group  col-md-4 no-padding">
                        <?= $form->field($model, 'date_begin')->textInput(['id'=>'date_begin']) ?>
                    </div>
                    <div class="form-group  col-md-4">
                        <?= $form->field($model, 'date_end')->textInput(['id'=>'date_end']) ?>
                    </div>
                    <div class="clearfix"></div>

                    <?= $form->field($model, 'banner_order')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    <?= backend\modules\posts\components\UpImageWidgets::widget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
         $('#date_begin').datepicker({
            autoclose: true,
            format: 'mm-dd-yyyy',
            
          });
           $('#date_end').datepicker({
            autoclose: true,
            format: 'mm-dd-yyyy',
          });
    });
</script>