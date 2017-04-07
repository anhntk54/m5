
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'PIN_REQUIRED_TITLE');
$this->params['breadcrumbs'][] = $this->title;
list(, $url) = Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/select2');
$this->registerJsFile($url . '/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($url . '/select2.min.css');
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_2'); ?></h1>
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
                <p class="font-gray-dark">
                    <?= Yii::t('app', 'PIN_BUY_COUNT') . ":" . $countPin; ?>
                </p>
                <?= $form->field($model, 'member_id')->dropDownList([], ['autofocus' => true, 'placeholder' => Yii::t('app', 'PIN_BUY_COUNT'), 'class' => 'form-control', 'id' => 'pin_member']); ?>
                <?= $form->field($model, 'count')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'PIN_BUY_COUNT'), 'class' => 'form-control col-md-7 col-xs-12']); ?>
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Password'), 'class' => 'form-control col-md-7 col-xs-12']); ?>
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
<script type="text/javascript">
    function formatValues(data) {
        return data.username;
    }
    $(document).ready(function () {
        $("#pin_member").select2({
            placeholder: "<?= Yii::t('app', 'PIN_MEMBER_RECEIVE') ?>",
            ajax: {
                url: "<?= Url::to(['/M5/pin/selectmember']) ?>",
                dataType: 'json',
                type: "POST",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatValues, // omitted for brevity, see the source of this page
            templateSelection: formatValues
        });
    });
</script>