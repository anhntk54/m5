<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('app', 'MENU_MEMBER_TREE');
$this->params['breadcrumbs'][] = $this->title;
list(, $url) = Yii::$app->assetManager->publish('@webroot/js');
$this->registerJsFile($url . '/tree.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
list(, $url) = Yii::$app->assetManager->publish('@webroot/css');
$this->registerCssFile($url . '/tree.css');
?>
<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h1 class="box-title"><?php echo Yii::t('app', 'TITLE_TREE'); ?></h1>
    </div>
    <div class="box-body">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                
            <ul id="tree3">
                <?= \frontend\modules\Member\components\OneTreeWidgets::widget(['model'=>$model,'count'=>1]); ?>
            </ul>
            </div>
        </div>


    </div>
    <!-- /.box-body -->
</div>