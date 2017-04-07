<div class="col-md-4 pull-right">
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
            <?php 
                if ($type == 'slider') {
                    echo \backend\modules\posts\components\images\SliderImageWidgets::widget(['model'=>$model]);
                }  else {
                    echo \backend\modules\posts\components\images\SelectImageWidgets::widget(['model'=>$model]);
                }
            ?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>