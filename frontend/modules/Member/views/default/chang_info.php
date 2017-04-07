

<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/moment/min');
$this->registerJsFile($url . '/moment.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/bootstrap-daterangepicker/');
$this->registerCssFile($url . '/daterangepicker.css');
$this->registerJsFile($url . '/daterangepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = Yii::t('app', 'MEMBER_CHANGE_INFO_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_2'); ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options'=>['class' => 'form-horizontal form-label-left']]); ?>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">

                <?=
                $form->errorSummary($model, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]);
                ?>
                <div class="control-group">
                    <label class="col-sm-5 control-label" for="first-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_DISPLAY_NAME'); ?> <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'display_name')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_DISPLAY_NAME'), 'class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-5 control-label" for="first-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_CARD_ID');?> <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'card_id')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_CARD_ID'), 'class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-5 control-label" for="last-name"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_MOBILE');?><span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'mobile')->textInput(['autofocus' => true, 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_MOBILE')])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="middle-name"
                           class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_USER_NAME'); ?></label>
                    <div class="col-sm-6 col-xs-12">
                        <?= $form->field($model, 'bank_username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_USER_NAME')])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="middle-name" class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_CODE'); ?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'bank_code')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_CODE')])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="middle-name" class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_NAME');?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'bank_name')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_NAME')])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="middle-name" class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_AGENCY'); ?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'bank_agency')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_AGENCY')])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_GENER'); ?></label>
                    <div class="col-sm-6">
                        <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default <?= $model->gender == "male" ? "active" : "" ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="ChangeInfoForm[gender]" value="male" data-parsley-multiple="gender"> &nbsp; <?= Yii::t('app', 'MEMBER_CHANGE_INFO_GENER_MALE'); ?> &nbsp;
                            </label>
                            <label class="btn btn-primary <?= $model->gender == "female" ? "active" : "" ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="ChangeInfoForm[gender]" value="female" data-parsley-multiple="gender"> <?= Yii::t('app', 'MEMBER_CHANGE_INFO_GENER_FEMALE');?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BIRTH_DAY'); ?>
                    </label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'birth_day')->textInput(['autofocus' => true, 'id' => 'birthday'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'MEMBER_CHANGE_INFO_AVATAR'); ?>
                    </label>
                    <div class="col-sm-6">
                        <img id="img-link" width="128px" src="<?= $model->getAvatar() ?>"/>
                        <button type="button" class="btn btn-round btn-default" onclick="document.getElementById('select-file').click();">Chọn ảnh</button>
                         <?= $form->field($model, 'avatar')->hiddenInput(['autofocus' => true, 'id' => 'avatar'])->label(false) ?>
                        <?= $form->field($model, 'change_avatar')->hiddenInput(['autofocus' => true, 'id' => 'change_avatar'])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'BTN_CHANGE'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        <a onclick="window.history.back();" class="btn"><?= Yii::t('app', 'BTN_CANNEL'); ?></a>
    </div>
<?php ActiveForm::end(); ?>
    <!-- /.box-body -->
</div>

<form action="" method="post" enctype="multipart/form-data" name="uploadForm" id="upload-form" style="display: none;">
    <input type="file" id="select-file" name="image">
</form>
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
        $('input#select-file').bind('change', function () {
            if (this.files.length > 0) {
                var file = this.files[0];
                console.log(file);
                        var fd = new FormData();
                fd.append('image', file);
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (match.indexOf(file.type) > -1) {
                    $.ajax({
                        type: "POST",
                        url: '<?= Url::to(["/Member/default/upimage"]); ?>',
                        data: fd,
                        dataType: 'html',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            var data = JSON.parse(result);
                            $('#img-link').attr('src',data.link);
                            $('#avatar').val(data.name);
                            $('#change_avatar').val(1);
                        }
                    });
                }
            }

        });
    }

</script>