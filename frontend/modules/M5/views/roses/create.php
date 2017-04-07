<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'ROSES_CREATE_TITLE');;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_3'); ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => 'form-horizontal form-label-left']); ?>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">
                <?=
                $form->errorSummary($model, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]);
                ?>
                <h4><?= Yii::t('app', 'VIEW_NOTE'); ?></h4>
                <p class="font-gray-dark">
                    <?= sprintf(Yii::t('app', 'VIEW_CREATE_GIVE_NOTE_PIN'),$model->count_pin); ?>
                </p>
                <p class="font-gray-dark">
                    <?= sprintf(Yii::t('app', 'ROSES_COUNT_OF_WEEK'),$count); ?>
                </p>
                <p class="font-gray-dark">
                    <?= Yii::t('app', 'ROSES_MONEY_CURRENT').\common\func\FunctionCommon::formatMoney($model->money) ?>.
                </p>
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
