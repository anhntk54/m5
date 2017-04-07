
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\models\Config;
$this->title = Yii::t('app', 'MEMBER_SIGNUP_RESET_PASSWORD_TITLE');
$this->params['breadcrumbs'][] = $this->title;
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
        <p class="login-box-msg"><?= Yii::t('app', 'MEMBER_SIGNUP_RESET_PASSWORD_NOTE'); ?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); 
        
            $form->errorSummary($model);
        ?>
        
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('app', 'BTN_CHANGE'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <div class="col-xs-4 ">
            	<a class="btn" href="<?= Url::to(['/Member/default/login']) ?>"><?= Yii::t('app', 'BTN_LOGIN'); ?></a>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
