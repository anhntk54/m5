<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
list(, $url) = Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/datatables');
$this->registerJsFile($url . '/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/dataTables.bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($url . '/dataTables.bootstrap.css');
list(, $url) = Yii::$app->assetManager->publish('@webroot/js');
$this->registerJsFile($url . '/countdown.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_5'); ?></h1>
    </div>
    <div class="box-body">
<table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= Yii::t('app', 'VIEW_LIST_TABLE_SEND_MONEY'); ?></th>
                            <th><?= Yii::t('app', 'VIEW_LIST_TABLE_STATUS'); ?></th>
                            <th><?= Yii::t('app', 'VIEW_LIST_TABLE_TIME_END'); ?></th>
                            <th><?= Yii::t('app', 'VIEW_LIST_TABLE_LIST'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $value): ?>
                            <?php
                            $url = Url::to(['/M5/m5map/index', 'id' => $value->id]);
                            $link = Html::a('Danh sách', $url);
                            $statusText = $value->getStatus();
                            $date = $value->getDate();
                            ?>
                            <tr>
                                <td><?= \common\func\FunctionCommon::formatMoney($value->money); ?></td>
                                <td class="status"><?= $statusText; ?></td>
                                <td data-date="<?= $date; ?>" class="date" id="date<?= $value->id ?>"><?= $value->getTimeEnd(); ?></td>
                                <td class="link"><?= $link; ?></td>
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


        $('.date').each(function () {
            var _id = $(this).attr('id');
            var date = $(this).attr('data-date');
            console.log('aksjsjkl');
            if (date != -1) {
                var parent = $(this).parent();
                var id = parent.find('.id').html();
                var type = "m5";
                var myCounter = new Countdown({
                    id: _id,
                    onCounterEnd: function () {
                        window.location.reload();

                    } // final action
                });
                myCounter.start();
            }

        });
    }
</script>