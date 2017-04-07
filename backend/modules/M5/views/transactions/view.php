<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Chi tiết mua pin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-view']); ?>
            <?php echo $form->errorSummary($model); ?>
            <div class="form-group">
                <label>Tên người mua:<?= $model->member->username; ?></label><br>
                <label>Số lượng:<?= $model->count; ?></label><br>
                <label>Số tiền:<?= $model->money; ?></label><br>
            </div>
            <div class="form-group">
                <?php
                
                if ($model->member_action == 0 && $model->status == common\models\Transactions::SCENARIO_DEFAULT) {
                    echo Html::submitButton('Xác nhận', ['class' => 'btn btn-primary','id'=>'btn-submit', 'name' => 'signup-button']);
                }  
                ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>