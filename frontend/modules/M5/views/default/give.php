<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'MENU_REGISTER');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?=  Yii::t('app', 'TITLE_3'); ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => 'form-horizontal form-label-left']); ?>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?=
                $form->errorSummary($model, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]);
                ?>
                <h4><?= Yii::t('app', 'VIEW_NOTE'); ?></h4>
                <p class="font-gray-dark">
                    <?= sprintf(Yii::t('app', 'VIEW_CREATE_GIVE_NOTE_PIN'), $model->count_pin); ?>
                </p>
                <p class="font-gray-dark">
                    <?= Yii::t('app', 'VIEW_CREATE_GIVE_MONEY') . \common\func\FunctionCommon::formatMoney($model->money) ?>.
                </p>
                <div class="form-group">
                    <label></label>
                </div>


            </div>
        </div>


    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'BTN_SUBMIT'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        <a onclick="window.history.back();" class="btn"><?= Yii::t('app', 'BTN_CANNEL'); ?></a>
    </div>
<?php ActiveForm::end(); ?>
    <!-- /.box-body -->
</div>
