<?php

use yii\helpers\Url;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" id="show-log" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-success"><?= $count > 0 ? $count : ''; ?></span>
    </a>
    <ul class="dropdown-menu">
        <?php if($count > 0): ?>
        <li class="header" id="count-log"><?= sprintf(Yii::t('app', 'MESSAGE_COUNT_NOT_READ'),$count) ?></li>
        <?php endif; ?>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <?php
                foreach ($data as $value) {
                    echo frontend\modules\M5\components\logs\OneLogsWidgets::widget(['model' => $value]);
                }
                ?>
            </ul>
        </li>
        <?php if(count($data) > 0): ?>
        <li class="footer"><a href="<?= Url::to(['/M5/logs/index']) ?>"><?= Yii::t('app', 'LOG_VIEW_ALL') ?></a></li>
        <?php endif; ?>
    </ul>
</li>

<script>
    window.addEventListener("load", function () {
        $(document).delegate("#show-log", "click", function (event) {

            if ($('#show-log span').html() != '') {
                $.ajax({
                    url: '<?= Url::to(['/M5/logs/view']); ?>',
                    type: 'post',
                    success: function (data) {
                        $('#show-log span').html('');
                    }
                });
            }else{
                $('#count-log').remove();
            }

        });
    }, false);
</script>