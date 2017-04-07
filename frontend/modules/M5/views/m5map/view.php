<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'M5_MAP_VIEW_TITLE');
$this->params['breadcrumbs'][] = $this->title;

$isCreate = $value->checkCreateReport();
$status = $value->getStatus();
$statusText = $value->getStatusText();
$checkUserAction = Yii::$app->user->id == $value->member_action;
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_3'); ?></h1>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-viewm5', 'class' => 'form-horizontal form-label-left']); ?>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12">
                <?=
                $form->errorSummary($value, [
                    'class' => 'alert alert-danger alert-dismissible fade in',
                ]);
                ?>
                <h4><?= Yii::t('app', 'M5_MAP_VIEW_DETAIL'); ?></h4>
                <p class="font-gray-dark"><?= Yii::t('app', 'M5_MAP_VIEW_DETAIL_MEMBER_RECEIVE') . $value->membertake->username; ?></p><br>
                <p class="font-gray-dark"><?= Yii::t('app', 'M5_MAP_VIEW_DETAIL_MEMBER_SEND') . $value->membergive->username; ?></p><br>
                <?php if(!$checkUserAction ): ?>
                <p class="font-gray-dark"><?= Yii::t('app', 'M5_MAP_VIEW_MOBILE_MEMBER_SEND') . $value->membergive->mobile; ?></p><br>
                <?php endif; ?>
                <p class="font-gray-dark"><?= Yii::t('app', 'M5_MAP_VIEW_DETAIL_MONEY') . \common\func\FunctionCommon::formatMoney($value->money); ?></p><br>
                <p class="font-gray-dark"><?= Yii::t('app', 'M5_MAP_VIEW_DETAIL_STATUS') . $statusText ?></p><br>

                <?php if($checkUserAction ): ?>
                    <h4><?= Yii::t('app', 'M5_MAP_VIEW_INFO_MEMBER'); ?></h4>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= Yii::t('app', 'MEMBER_CHANGE_INFO_BANK_DISPLAY_NAME'); ?></th>
                            <th><?= Yii::t('app', 'M5_MAP_VIEW_INFO_MEMBER_ACCOUNT'); ?></th>
                            <th><?= Yii::t('app', 'M5_MAP_VIEW_INFO_MEMBER_PBRANCH'); ?></th>
                            <th><?= Yii::t('app', 'M5_MAP_VIEW_INFO_MEMBER_BANK'); ?></th>
                            <th><?= Yii::t('app', 'MEMBER_CHANGE_INFO_MOBILE'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $value->membertake->bank_username; ?></td>
                            <td><?= $value->membertake->bank_code; ?></td>
                            <td><?= $value->membertake->bank_agency; ?></td>
                            <td><?= $value->membertake->bank_name; ?></td>
                            <td><?= $value->membertake->mobile; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif;?>
                <?= $form->field($value, 'report')->hiddenInput(['id' => 'input_report'])->label(FALSE) ?>
            </div>
        </div>


    </div>

    <div class="box-footer">
        <?php
        if ($status == 1 || $status == 4) {
            echo Html::submitButton(Yii::t('app', 'BTN_SUBMIT'), ['class' => 'btn btn-success', 'id' => 'btn-submit', 'name' => 'signup-button']);
        }
        if ($isCreate) {
            echo Html::Button(Yii::t('app', 'BTN_REPORT'), ['class' => 'btn btn-success', 'id' => 'btn-report', 'name' => 'signup-button']);
        }
        ?>
        <a onclick="window.history.back();" class="btn"><?= Yii::t('app', 'BTN_CANNEL'); ?></a>
    </div>
<?php ActiveForm::end(); ?>
    <!-- /.box-body -->
</div>
<script type="text/javascript">
    window.onload = function () {
        $('#btn-report').click(function (e) {
            $('#input_report').val(1);
            $('#form-viewm5').submit();
        })
    }
</script>