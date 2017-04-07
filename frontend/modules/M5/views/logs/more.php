<?php

foreach ($model as $value) {
    echo frontend\modules\M5\components\logs\ViewOneLogsWidgets::widget(['model' => $value]);
}
?>