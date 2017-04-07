
<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\M5;

$userCurrent = Yii::$app->user->id;
$this->title = Yii::t('app', 'M5_MAP_LIST_TITLE_GD');
$note = Yii::t('app', 'M5_MAP_LIST_MONEY_END_GD') . $m5->money_current;
if ($m5->type == M5::TYPE_GIVE) {
    $this->title = Yii::t('app', 'M5_MAP_LIST_TITLE_PD');
    $note = Yii::t('app', 'M5_MAP_LIST_MONEY_END_PD') . $m5->money_current;
}
list(, $url) = Yii::$app->assetManager->publish('@vendor/almasaeed2010/adminlte/plugins/datatables');
$this->registerJsFile($url . '/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile($url . '/dataTables.bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile($url . '/dataTables.bootstrap.css');
list(, $url) = Yii::$app->assetManager->publish('@webroot/js');
$this->registerJsFile($url . '/countdown.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_4'); ?></h1>
    </div>
    <div class="box-body">
<?php if ($m5->money_current > 0): ?>
            <h4><?php echo Yii::t('app', 'VIEW_NOTE'); ?></h4>
            <p class="font-gray-dark">
            <?= $note; ?>
            </p>
<?php endif; ?>
        <table id="datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?= Yii::t('app', 'M5_MAP_LIST_TABLE_KEY_CODE'); ?></th>
                    <th><?= $m5->type == M5::TYPE_GIVE ? Yii::t('app', 'M5_MAP_LIST_MEMBER_RECEIVE') : Yii::t('app', 'M5_MAP_LIST_MEMBER_SEND') ?></th>
                    <th><?= Yii::t('app', 'M5_MAP_LIST_TABLE_MONEY'); ?></th>
                    <th><?= Yii::t('app', 'M5_MAP_LIST_TABLE_TIME'); ?></th>
                    <th><?= Yii::t('app', 'M5_MAP_LIST_TABLE_STATUS'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model as $value): ?>
                    <?php
                    $link = Url::to(['/M5/m5map/view', 'id' => $value->id]);
                    $status = $value->getStatus();
                    $statusText = Html::a($value->getStatusText(), $link);
                    ?>

                    <tr>
                        <td><?= $value->getId()  ?></td>
                        <td><?= $value->member_id == $userCurrent ? $value->membergive->username : $value->membertake->username; ?></td>
                        <td><?= $value->money; ?></td>
                        <td data-date="<?= $value->getDate(); ?>" class="date" id="date<?= $value->id ?>"><?= $value->getTimeEnd(); ?></td>
                        <td><?= $statusText; ?></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>


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