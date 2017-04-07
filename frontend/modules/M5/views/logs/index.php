<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'ALL_LOGS');
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>

                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped" id="datatable">
                        <tbody id="databae-body">
                            <?php 
                            foreach ($model as $value){
                                echo frontend\modules\M5\components\logs\ViewOneLogsWidgets::widget(['model'=>$value]);
                            } 
                            ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
            </div>
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>
<script>
    var count = 1;
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
               $.ajax({
                   url: '<?= Url::to(['/M5/logs/more']) ?>',
                   type: 'POST',
                   data: {count:count},
                   success:function (data) {
                       $("#databae-body").append(data);
                       count++;
                   }
               });
               
        }
    });
</script>