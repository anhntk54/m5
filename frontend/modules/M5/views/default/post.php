<?php 
use yii\helpers\Url;
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= \frontend\modules\M5\components\CategoryIndexWidgets::widget(['category'=>$category,'cate'=>$cate]) ?>
    <div class="col-md-9">
      <div class="box box-primary post-detail">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $this->title ?></h3>
          <div class="post-info">
            <span><i class="fa fa-clock-o"></i> <?= date('d-m-Y H:i',  strtotime($model->create_at)) ?></span>
            <span class="post-seperate">-</span>
            <span><i class="fa fa-list"></i> <a href="<?= Url::to(['/M5/default/index','slug'=>$cate->slug]); ?>"><?= $cate->title ?></a></span>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <!-- /.mailbox-controls -->
            <div class="mailbox-read-message">
              <?= $model->description ?>
            </div>
          <!-- /.box-footer -->
        </div>
        <!-- /. box -->
      </div>
      <!-- /.col -->
    </div>
</div>