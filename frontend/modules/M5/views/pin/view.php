<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Member;

$this->title = 'Chi tiết mua pin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= Html::encode($this->title) ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'class' => 'form-horizontal form-label-left']); ?>
                <?= $form->errorSummary($model,[
                    'class'=>'alert alert-danger alert-dismissible fade in',
                ]); ?>
                <h4>Chi tiết</h4>
                <p class="font-gray-dark">Tên người mua:<?= $model->member->username; ?></p>
                <p class="font-gray-dark">Số lượng:<?= $model->count; ?></p>
                <p class="font-gray-dark">Số tiền:<?= $model->money; ?></p>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button onclick="window.history.back();" class="btn btn-primary">Hủy bỏ</button>
                        <?php
                
                        if ($model->table_name == Member::tableName() && $model->table_id == \Yii::$app->user->id && $model->status == common\models\Transactions::SCENARIO_DEFAULT) {
                            echo Html::submitButton('Xác nhận', ['class' => 'btn btn-success','id'=>'btn-submit', 'name' => 'signup-button']);
                        }  
                        ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>