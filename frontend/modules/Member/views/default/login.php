

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Config;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'MEMBER_LOGIN_TITLE');
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><?= Config::getValueConfig("nameApp") ?></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> <?= Yii::t('app', 'SUCCESS') ?></h4>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <p class="login-box-msg"><?= Yii::t('app', 'MEMBER_LOGIN_TITLE'); ?></p>

        <?php
        $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]);

        $form->errorSummary($model);
        ?>

        <?=
                $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('username')])
        ?>

        <?=
                $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
        ?>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('app', 'BTN_LOGIN'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <div class="col-xs-4 ">
                <a class="btn" href="<?= Url::to(['/Member/default/requestpasswordreset']) ?>"><?= Yii::t('app', 'MEMBER_LOGIN_LOST_PASSWORD') ?></a>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
