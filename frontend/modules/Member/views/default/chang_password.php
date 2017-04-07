<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'MEMBER_CHANGE_PASSWORD_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_2'); ?></h1>
    </div>
     <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>[ 'class' => 'form-horizontal form-label-left']]); ?>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">

                <?=
                $form->errorSummary($model, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]);
                ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?= Yii::t('app', 'MEMBER_CHANGE_PASSWORD_OLD'); ?> <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'password_old')->passwordInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_OLD'), 'class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?= Yii::t('app', 'MEMBER_CHANGE_PASSWORD_NEW') ?><span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_NEW')])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"><?= Yii::t('app', 'MEMBER_CHANGE_PASSWORD_REPEAT') ?></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'password_repeat')->passwordInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'MEMBER_CHANGE_PASSWORD_REPEAT')])->label(false) ?>
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
