<?php

foreach ($images as $image) {
    if ($type == 'list') {
        echo backend\modules\posts\components\images\ImageViewPostWidgets::widget(['image' => $image]);
    } else {
        echo \backend\modules\posts\components\images\OneImageSliderWidgets::widget(['model' => $image]);
    }
}