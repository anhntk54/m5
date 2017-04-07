<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Tags */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Cấu hình tổng quan";
?>
<h1><?= Html::encode("Cấu hình ") ?></h1>
<div class="tags-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a data-target="#home" data-toggle="tab">Tổng quan</a></li>
                        <li><a data-target="#profile" data-toggle="tab">Hoa hồng</a></li>
                        <li><a data-target="#time" data-toggle="tab">Thời gian</a></li>
                        <li><a data-target="#cycle" data-toggle="tab">Vòng quay</a></li>
                    </ul>

                    <div class="tab-content" style="height: 392px;">
                        <div class="tab-pane active select-input" id="home">
                            <div id="uploadFormLayer" style="height: 400px;">
                                <?= $form->field($model, 'baseUrl')->textInput() ?>
                                <?= $form->field($model, 'nameApp')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'm5_count_pd')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'send_mail')->checkbox(['maxlength' => true]) ?>
                                <?= $form->field($model, 'create_logs_member')->checkbox(['maxlength' => true]) ?>

                            </div>
                        </div>
                        <div class="tab-pane" id="profile">
                            <div class="tab-2 row no-margin row">
                                <div class="col-md-5">
                                    <?= $form->field($model, 'm5_price')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_direct')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_sytem_1')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_sytem_2')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($model, 'm5_precent')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_sytem_3')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_sytem_4')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_roses_sytem_5')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="time">
                            <div class="tab-2 row no-margin row">
                                <?= $form->field($model, 'type_add_time')->dropDownList($model->getTypeAddTime(),['prompt'=>"Chọn kiểu thời gian"]) ?>
                                <?= $form->field($model, 'm5_time_pending_transaction')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'm5_time_action_transaction')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'm5_time_pending_transaction_gd')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'time_cron')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="cycle">
                            <div class="tab-2 row no-margin row">
                                <div class="col-md-5">
                                    <?= $form->field($model, 'm5_cycle_min')->textInput(['maxlength' => true]) ?>
                                    <?= $form->field($model, 'm5_cycle_count_day')->textInput(['maxlength' => true]) ?>
                                    
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($model, 'm5_cycle_max')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>



                    
                </div>
            </div>
        </div>
        <div class="form-group">
                        <?= Html::submitButton("Chỉnh sửa", ['class' => 'btn btn-primary']) ?>
                    </div>
        <?php ActiveForm::end(); ?>

    </div>