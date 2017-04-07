<?php

use yii\helpers\Html;
?>
<div class="col-md-8 no-padding">
    <div  class="col-md-5 no-padding "><h1 class="no-margin no-padding"><?= Html::encode($this->title) ?></h1> </div>
    <div class="col-md-3 no-margin no-padding ">
        <?php 
            if ($table != 'images'){
                if ($type == '') {
                    echo Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']);
                }  else {
                    echo Html::a('Tạo mới', ['create','type'=>$type], ['class' => 'btn btn-success']);
                }
            }
        ?>
    </div>
</div>
<div class="col-md-8 no-padding">
    <?= Html::dropDownList('s_id', null, $dataList, ['class' => 'form-control col-md-4', 'style' => "width: 30%;", 'id' => "phanloai", "prompt" => "Chọn"])
    ?>
    <button class="btn btn-default btn-apdung">Áp dụng</button> 
    <?php if ($table != 'images'): ?>
        |
        <?php
            $i = 0;
            foreach ($arrTitle as $value) {
                if ($i == count($arrTitle) - 1) {
                    echo Html::a($value['title'], ['index', 'filer' => $value['filer']]) . " (".$value['count'].") ";
                }  else {
                    echo Html::a($value['title'], ['index', 'filer' => $value['filer']]) . " (".$value['count'].") |";
                }
                $i++;
            }
        ?>
    <?php endif; ?>
</div>
<div class="clearfix"></div>
<script>
    $('.btn-apdung').click(function () {
        var ids = $('#w0').yiiGridView('getSelectedRows');

        var action = $('#phanloai').val();
        if (action) {
            $.ajax({
                url: "<?= $link ?>",
                type: "POST",
                data: {ids: JSON.stringify(ids), action: action},
                success: function (data)
                {
                    $('#w0').yiiGridView("applyFilter");
                },
            });
        }
        return false;
    });
</script>
<style>
    .summary{
        position: absolute;
        right: 0;
        top: -32px;
    }
    .grid-view{position: relative;}
</style>