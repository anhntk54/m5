<?php

use yii\helpers\Html;
?>
<div class="col-md-4">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $title ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?= $titleTab1 ?></a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?= $titleTab2 ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="checkbox" style="overflow-y: scroll;height: 100px;background: #eee;padding: 10px;">
                            <?php foreach ($categoriesChecks as $key): ?>
                            <label><input type="checkbox" name="category[]" checked="checked" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                            <?php foreach ($data as $key): ?>
                                <label><input type="checkbox" name="category[]" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                        </div>
                        <div class="add-category" >
                            <a id="a-add-category" onclick="$('#form-add-categgory').toggle();return;" >+ Thêm danh mục</a><br><br>

                            <div id="form-add-categgory" style="display: none;">
                                <input class="form-control input-sm" type="text" id='input-category' placeholder="Tên danh mục"><br>
                                <?= Html::dropDownList("add", NULL, \yii\helpers\ArrayHelper::map($dataParent, "id", "title"), ["class" => "form-control", "prompt" => "Danh mục cha", "id" => "select_id_category"]) ?>
                                <br><button type="button" id="button-addcategory" onclick="SendAjaxCategory();" class="btn btn-block btn-default">Thêm danh mục</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="checkbox" style="overflow-y: scroll;height: 100px;background: #eee;padding: 10px;">
                            <?php foreach ($categoryUse as $key): ?>
                                <label><input type="checkbox" name="category[]" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>


        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>

<script>
    function SendAjaxCategory() {
        console.log("k vao");
        $.ajax({//Process the form using $.ajax()
            type: 'POST', //Method type
            url: '<?= yii\helpers\Url::to("?r=posts/category/postcategory"); ?>', //Your form processing file URL
            data: {id: $('#select_id_category').val(), name: $('#input-category').val(),type:"<?= $type ?>"}, //Forms name
            dataType: "json",
            success: function (data) {
                $('#input-category').val("");
                $('#select_id_category').html(data.html);
                $('.checkbox').prepend(data.title);
            },
        });
    }
</script>