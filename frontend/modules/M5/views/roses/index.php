<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\M5;
use common\models\Transactions;

$this->title = Yii::t('app', 'ROSES_LIST_INDEX_TITLE');
$this->params['breadcrumbs'][] = $this->title;
list(, $url) = Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/datatables');
$this->registerJsFile($url . '/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/dataTables.bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($url . '/dataTables.bootstrap.css');
?>
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_4'); ?></h1>
        </div>
        <div class="box-body">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?= Yii::t('app', 'ROSES_LIST_TABLE_ID'); ?></th>
                        <th><?= Yii::t('app', 'ROSES_LIST_TABLE_MONEY'); ?></th>
                        <th><?= Yii::t('app', 'ROSES_LIST_TABLE_TIME'); ?></th>
                        <th><?= Yii::t('app', 'ROSES_LIST_TABLE_STATUS'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model as $value): ?>
                        <?php
                        $statusText = Yii::t('app', 'ROSES_LIST_TABLE_STATUS_FINISH');
                        if ($value->status == Transactions::STATUS_START) {
                            $statusText = Yii::t('app', 'ROSES_LIST_TABLE_STATUS_PENDING');
                        }
                        if ($value->m5 && $value->m5->viewed == M5::VIEW_END) {
                            $statusText = \yii\helpers\Html::a($statusText, Url::to(['/M5/m5map/index', 'id' => $value->m5->id]));
                        }
                        ?>
                        <tr>
                            <td><?= $value->id; ?></td>
                            <td><?= $value->money; ?></td>
                            <td><?= date('d-m-Y', strtotime($value->created_at)); ?></td>
                            <td><?= $statusText; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>

        <!-- /.box-body -->
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