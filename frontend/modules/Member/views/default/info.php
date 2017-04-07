<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Member;

$this->title = Yii::t('app', 'INFO_TITLE');
$this->params['breadcrumbs'][] = $this->title;
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/moment/min');
$this->registerJsFile($url . '/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/bootstrap-daterangepicker/');
$this->registerCssFile($url . '/daterangepicker.css');
$this->registerJsFile($url . '/daterangepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'INFO_TITLE_2'); ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="box-body">
        <div class="row">


            <div class="row bs-wizard" style="border-bottom:0;">
                <?php foreach ($steps as $key => $value): ?>
                    <?php $class = $value['active'] ? 'complete' : 'disabled'; ?>
                    <div class="col-xs-4 bs-wizard-step <?= $class ?>">
                        <div class="text-center bs-wizard-stepnum"><?= sprintf(Yii::t('app', 'INFO_STEP'), $key + 1) ?></div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center"><?= $value['title'] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?=
                $form->errorSummary($model, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]); ?>
                <?php if($model->status == Member::STATUS_ACTIVE): ?>
                <div class="control-group">
                    <label class="col-sm-3 control-label"
                           for="first-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_DISPLAY_NAME'); ?> <span
                                class="required">*</span>
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($model, 'display_name')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_DISPLAY_NAME'), 'class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="clear" style="clear: both;"></div>
                <div class="control-group">
                    <label class="col-sm-3 control-label"
                           for="first-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_CARD_ID'); ?> <span
                                class="required">*</span>
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($model, 'card_id')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_CARD_ID'), 'class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="clear" style="clear: both;"></div>
                <div class="control-group">
                    <label class="col-sm-3 control-label"
                           for="last-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_MOBILE'); ?><span
                                class="required">*</span>
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($model, 'mobile')->textInput(['autofocus' => true, 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_MOBILE')])->label(false) ?>
                    </div>
                </div>
                <div class="clear" style="clear: both;"></div>
                <div class="control-group">
                    <label class="col-sm-3 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BIRTH_DAY'); ?>
                    </label>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($model, 'birth_day')->textInput(['autofocus' => true, 'id' => 'birthday'])->label(false) ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($model->status == Member::STATUS_ADD_INFO): ?>
                    <div class="control-group">
                        <label for="middle-name"
                               class="col-sm-3 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_USER_NAME'); ?></label>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank_username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_USER_NAME')])->label(false) ?>
                        </div>
                    </div>
                    <div class="clear" style="clear: both;"></div>
                    <div class="control-group">
                        <label for="middle-name"
                               class="col-sm-3 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_CODE'); ?></label>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank_code')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_CODE')])->label(false) ?>
                        </div>
                    </div>
                    <div class="clear" style="clear: both;"></div>
                    <div class="control-group">
                        <label for="middle-name"
                               class="col-sm-3 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_NAME'); ?></label>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank_name')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_NAME')])->label(false) ?>
                        </div>
                    </div>
                    <div class="clear" style="clear: both;"></div>
                    <div class="control-group">
                        <label for="middle-name"
                               class="col-sm-3 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_AGENCY'); ?></label>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'bank_agency')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_AGENCY')])->label(false) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($model->status == Member::STATUS_ACTIVED): ?>
                    <div style="text-align: center;">
                        <i class="fa fa-check-square"></i><span><?= Yii::t('app','INFO_COMPLETE') ?></span>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php if($model->status != Member::STATUS_ACTIVED): ?>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'BTN_CHANGE'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
    </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
    <!-- /.box-body -->
</div>

<style>
    .bs-wizard {
        margin-top: 40px;
    }

    /*Form Wizard*/
    .bs-wizard {
        border-bottom: solid 1px #e0e0e0;
        padding: 0 0 10px 0;
    }

    .bs-wizard > .bs-wizard-step {
        padding: 0;
        position: relative;
    }

    .bs-wizard > .bs-wizard-step + .bs-wizard-step {
    }

    .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {
        color: #595959;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .bs-wizard > .bs-wizard-step .bs-wizard-info {
        color: #999;
        font-size: 14px;
    }

    .bs-wizard > .bs-wizard-step > .bs-wizard-dot {
        position: absolute;
        width: 30px;
        height: 30px;
        display: block;
        background: #fbe8aa;
        top: 45px;
        left: 50%;
        margin-top: -15px;
        margin-left: -15px;
        border-radius: 50%;
    }

    .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {
        content: ' ';
        width: 14px;
        height: 14px;
        background: #fbbd19;
        border-radius: 50px;
        position: absolute;
        top: 8px;
        left: 8px;
    }

    .bs-wizard > .bs-wizard-step > .progress {
        position: relative;
        border-radius: 0px;
        height: 8px;
        box-shadow: none;
        margin: 20px 0;
    }

    .bs-wizard > .bs-wizard-step > .progress > .progress-bar {
        width: 0px;
        box-shadow: none;
        background: #fbe8aa;
    }

    .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {
        width: 100%;
    }

    .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {
        width: 50%;
    }

    .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {
        width: 0%;
    }

    .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {
        width: 100%;
    }

    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {
        background-color: #f5f5f5;
    }

    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {
        opacity: 0;
    }

    .bs-wizard > .bs-wizard-step:first-child > .progress {
        left: 50%;
        width: 50%;
    }

    .bs-wizard > .bs-wizard-step:last-child > .progress {
        width: 50%;
    }

    .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot {
        pointer-events: none;
    }

    /*END Form Wizard*/
</style>
<script>
    window.onload = function () {
        $(document).ready(function () {
            $('#birthday').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    }

</script>