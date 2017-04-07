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
                        <div class="checkbox checkboxBan" style="overflow-y: scroll;height: 100px;background: #eee;padding: 10px;">
                            <?php foreach ($categoriesBan as $key): ?>
                                <label><input type="checkbox" name="category[]" checked="checked" class="ban" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                            <?php foreach ($dataBan as $key): ?>
                                <label><input type="checkbox" name="category[]" class="ban" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                        </div>
                        <div class="add-category" >
                            <a id="a-add-category" onclick="$('#form-add-categgory1').toggle();return;" >+ Thêm danh mục</a><br><br>

                            <div id="form-add-categgory1" style="display: none;">
                                <input class="form-control input-sm" type="text" id='input-category' placeholder="Tên danh mục"><br>
                                <?= Html::dropDownList("add", NULL, \yii\helpers\ArrayHelper::map($dataParent, "id", "title"), ["class" => "form-control", "prompt" => "Danh mục cha", "id" => "select_id_categoryBan"]) ?>
                                <br><button type="button" id="button-addcategory" onclick="SendAjaxCategory('select_id_categoryBan');" class="btn btn-block btn-default">Thêm danh mục</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="checkbox checkboxThue" style="overflow-y: scroll;height: 100px;background: #eee;padding: 10px;">
                            <?php foreach ($categoriesThue as $key): ?>
                                <label><input type="checkbox" name="category[]" class="thue" checked="checked" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                            <?php foreach ($dataThue as $key): ?>
                                <label><input type="checkbox" name="category[]" class="thue" value="<?= $key->id; ?>"><?= $key->title; ?></label><br>
                            <?php endforeach; ?>
                        </div>
                        <div class="add-category" >
                            <a id="a-add-category" onclick="$('#form-add-categgory2').toggle();return;" >+ Thêm danh mục</a><br><br>

                            <div id="form-add-categgory2" style="display: none;">
                                <input class="form-control input-sm" type="text" id='input-category2' placeholder="Tên danh mục"><br>
                                <?= Html::dropDownList("add", NULL, \yii\helpers\ArrayHelper::map($dataParent, "id", "title"), ["class" => "form-control select_id_category", "prompt" => "Danh mục cha", "id" => "select_id_categoryThue"]) ?>
                                <br><button type="button" id="button-addcategory" onclick="SendAjaxCategory('select_id_categoryThue');" class="btn btn-block btn-default">Thêm danh mục</button>
                            </div>
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
    $('.thue').change(function () {
        if ($(this).prop("checked")) {
             $('.ban').attr('checked',false);
        }
    })
    $('.ban').change(function () {
        if ($(this).prop("checked")) {
             $('.thue').attr('checked',false);
        }
    })
    function SendAjaxCategory(idselect) {
        var name = $('#input-category').val();
        if (idselect == 'select_id_categoryThue') {
            name = $('#input-category2').val()
        }
        $.ajax({//Process the form using $.ajax()
            type: 'POST', //Method type
            url: '<?= yii\helpers\Url::to("?r=posts/category/postcategory"); ?>', //Your form processing file URL
            data: {id: $('#' + idselect).val(), name: name, type: "<?= $type ?>"}, //Forms name
            dataType: "json",
            success: function (data) {
                $('.input-category').val("");
                $('.select_id_category').html(data.html);
                if (data.check == 14) {
                    $('.checkboxBan').prepend(data.title);
                } else if (data.check == 15) {
                    $('.checkboxThue').prepend(data.title);
                }
                
            },
        });
    }
</script>