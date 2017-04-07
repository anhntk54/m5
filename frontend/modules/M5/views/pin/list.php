<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\Transactions;
$this->title = Yii::t('app', 'PIN_LIST_BUY_PIN');
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net/js');
$this->registerJsFile($url . '/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-bs/js');
$this->registerJsFile($url . '/dataTables.bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-buttons-bs/js');
$this->registerJsFile($url . '/buttons.bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-buttons/js');
$this->registerJsFile($url . '/dataTables.buttons.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/buttons.flash.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/buttons.html5.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/buttons.print.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-fixedheader/js');
$this->registerJsFile($url . '/dataTables.fixedHeader.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-keytable/js');
$this->registerJsFile($url . '/dataTables.keyTable.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-responsive/js');
$this->registerJsFile($url . '/dataTables.responsive.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-responsive-bs/js');
$this->registerJsFile($url . '/responsive.bootstrap.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-scroller/js');
$this->registerJsFile($url . '/datatables.scroller.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-bs/css/');
$this->registerCssFile($url . '/dataTables.bootstrap.min.css');
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-buttons-bs/css/');
$this->registerCssFile($url . '/buttons.bootstrap.min.css');
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-fixedheader-bs/css/');
$this->registerCssFile($url . '/fixedHeader.bootstrap.min.css');
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-responsive-bs/css/');
$this->registerCssFile($url . '/responsive.bootstrap.min.css');
list(, $url) = Yii::$app->assetManager->publish('@bower/gentelella/vendors/datatables.net-scroller-bs/css/');
$this->registerCssFile($url . '/scroller.bootstrap.min.css');
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= $this->title ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= Yii::t('app', 'PIN_MEMBER_BUY_PIN'); ?></th>
                            <th><?= Yii::t('app', 'PIN_MEMBER_COUNT_PIN'); ?></th>
                            <th><?= Yii::t('app', 'PIN_MEMBER_MONEY'); ?></th>
                            <th><?= Yii::t('app', 'PIN_STATUS'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $value): ?>
                        <?php
                        $statusText = Yii::t('app', 'PIN_STATUS_FINISH');
                        if ($value->status == Transactions::STATUS_START) {
                            $statusText = Yii::t('app', 'PIN_STATUS_PENDING');
                        }
                        ?>
                        <tr>
                            <td><?= $value->member->username; ?></td>
                            <td><?= $value->count; ?></td>
                            <td><?= $value->money; ?></td>
                            <td><a href="<?= Url::to(['/M5/pin/view','id'=>$value->id]);?>"><?= $statusText; ?></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        $('#datatable').dataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/1.10.13/i18n/Vietnamese.json"
            }
        });
    }
</script>