<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\func\FunctionCommon;
$this->title = Yii::t('app', 'NEWS_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= \frontend\modules\M5\components\CategoryIndexWidgets::widget(['category'=>$category,'cate'=>$cate]) ?>
    <div class="col-md-9">
        <?php if($cateQ->id != $cate->id): ?>
        <div class="box box-primary color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $cate->title ?></h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <?php $i = 0; ?>
                <?php foreach ($posts as $value): ?>
                <div class="post">
                    <?php if($i == 0): ?>
                        <h4 class="post-title"><?= $value->getTitle() ?></h4>
                    <?php else: ?>
                        <span class="post-title"><?= $value->getTitle() ?></a></span>
                    <?php endif; ?>
                    <p class="post-info">
                        <span><i class="fa fa-clock-o"></i><?php echo "  ".date('m-d-Y H:i:s',  strtotime($value->create_at)); ?></span>
                    </p>
                    <div class="post-sapo">
                        <?php
                            $desc = $value->description;
                                if ($i == 0) {
                                    $desc = FunctionCommon::str_limit($desc, 800);
                                }  else {
                                    $desc = FunctionCommon::str_limit($desc,300);
                                }
                            echo $desc;
                        ?>
                        <a href="<?= $value->getLink(); ?>" >Read more...</a>
                    </div>
                </div>
                <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <!-- /.box-body -->
        </div>
        <?php endif; ?>
        <div class="box box-primary color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $cateQ->title ?></h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <?php foreach ($cateQ->posts as $i=>$value): ?>
                  <div class="panel">
                    <div class="panel-heading" role="tab" id="heading<?= $value->id ?>">
                      <div class="post-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value->id ?>" aria-expanded="<?php $i==0 ? 'false' : 'true' ?>" aria-controls="collapse<?= $value->id ?>">
                          <?= $value->title ?>
                        </a>
                      </div>
                    </div>
                    <div id="collapse<?= $value->id ?>" class="panel-collapse collapse<?php if($i==0) echo ' in'; ?>" role="tabpanel" aria-labelledby="heading<?= $value->id ?>">
                      <div class="panel-body">
                        <?= $value->description ?>
                      </div>
                    </div>
                  </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>