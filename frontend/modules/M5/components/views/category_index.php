<?php 
use common\models\Taxonomy;
use yii\helpers\Url;
?>
<div class="col-md-3">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Categories') ?></h3>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
<?php
foreach ($category as $cat):
    $active = $cate->id == $cat->id ? "active" : "";
    $icon = Taxonomy::getTaxonomy($cat->id, $cat->tableName(), common\func\StaticDefine::$ICON_CATEGORY);
    ?>
                    <li class="<?= $active ?>"><a href="<?= Url::to(['/M5/default/index', 'slug' => $cat->slug]); ?>"><?= $icon . $cat->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
</div>