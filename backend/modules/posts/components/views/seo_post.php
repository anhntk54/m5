<div class="col-md-12 no-padding">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Seo</h3>
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
                    <li class="active"><a href="#tab_seo_1" data-toggle="tab" aria-expanded="true">Bài viết</a></li>
                    <li class=""><a href="#tab_seo_2" data-toggle="tab" aria-expanded="false">Facebook</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_seo_1">
                        <p class="pull-right"><span id="leng_seotitle">0</span>/70</p>
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true, 'id' => 'seo_title', 'placeholder' => $model->attributeLabels()['seo_title']]) ?>

                        <p class="pull-right"><span id="lengseo_description">0</span>/160</p>
                        <?= $form->field($model, 'seo_description')->textarea(['rows' => 6,'id'=>'seo_description', 'placeholder' => $model->attributeLabels()['seo_description']]) ?>
                        <div class="clearfix"></div>
                        <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['seo_keyword']])->label(FALSE); ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_seo_2">
                        <?= $form->field($model, 'fb_title')->textInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['fb_title']])->label(FALSE); ?>

                        <?= $form->field($model, 'fb_description')->textarea(['rows' => 6, 'placeholder' => $model->attributeLabels()['fb_description']])->label(FALSE); ?>
                        <?php
                        $src = "";
                        if ($model->fbimage) {
                            $src = $model->fbimage->url;
                        }
                        ?>
                        <img id="fb-src-image" src="<?= $src ?>" style="width: 16%;" />
                        <a onclick="showPopupImage('#input-hidden-fb-image', '#fb-src-image');" class="btn btn-default">Chọn ảnh</a>
                        <?= $form->field($model, 'fb_image')->hiddenInput(['maxlength' => true, 'placeholder' => $model->attributeLabels()['seo_keyword'], 'id' => 'input-hidden-fb-image'])->label(FALSE); ?>
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
$(document).ready(function(){ 
        var string = $("#seo_title").val();
        var leng = string.length;
        $("#leng_seotitle").html(leng);
        var string = $("#seo_description").val();
        var leng = string.length;
        $("#lengseo_description").html(leng);
    });
    $("#seo_title").bind('keyup keypress keydown load',function () {
        
        var string = $("#seo_title").val();
        var leng = string.length;
        $("#leng_seotitle").html(leng);
    });
     $("#seo_description").bind('keyup keypress keydown load',function () {
        
        var string = $("#seo_description").val();
        var leng = string.length;
        $("#lengseo_description").html(leng);
    });
</script>
