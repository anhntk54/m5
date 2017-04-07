<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\posts\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\widgets\ActiveForm;
$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::getAlias("@web") . '/js/jquery.nestable.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::getAlias("@web") . '/js/jquery.nestable++.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::getAlias("@web") . '/css/nestable.css');
?>
<div class="menu-index">

    <h1 class="col-md-4"><?= Html::encode($this->title) ?> <?= Html::a('Quản lí menu', ['manage'], ['class' => 'btn btn-success']) ?></h1>
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <p class="col-md-3">Chọn menu để chỉnh sửa:</p>
                    <?php  ActiveForm::begin([ 'action' => ['/config/menu/index'],'id'=>'seclect-order-form','enableClientScript' => false,'method'=>'get']); ?>
                        <div class="col-md-4">
                            <?= Html::activeDropDownList($model, 'select_menu', \yii\helpers\ArrayHelper::map(backend\modules\config\models\Menu::find()->where(['parent_id' => 0])->all(), "id", "name"), ["class" => "form-control",'name'=>'id']) ?>
                        </div>
                        <div class="col-md-4" style="position: relative;"> 
                            <button type="submit" class="btn-default form-control col-md-4 a-link-menu"  style="width: 34%;">Lựa chọn</button>
                            <div style="position: absolute;top: 8px;right: 79px">
                                OR
                                <?= Html::a('Tạo menu mới', ['index', 'id' => 0, 'new' => 1], []) ?>
                            </div>
                        </div>
                     <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 pull-left">
            <?= backend\modules\config\components\AddMenuWidgets::widget(['title'=>'Danh mục','model'=>$category]) ?>
            <?= backend\modules\config\components\AddMenuWidgets::widget(['title'=>'Link tùy chỉnh']) ?>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border" style="padding:10px 10px 0px;">
                     <?php $form = ActiveForm::begin(); ?>
                    <?= $form->errorSummary($model); ?>
                    <input type="hidden" name="_csrf" value="<?=\Yii::$app->request->getCsrfToken()?>" />
                    <h3 class="box-title col-md-2" style="padding: 10px;">Menu </h3>
                        <div class="col-md-4 no-margin no-padding">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                            <?= $form->field($model, 'json_value')->hiddenInput(['id'=>'id_json_value'])->label(false) ?>
                        </div>
                        <div class="box-tools pull-right">
                            <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Chỉnh sửa', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'submit-form']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!-- /.box-tools -->
                    </div>
                <div class="box-body">
                    <div class="dd nestable" id="nestable">
                        <ol class="dd-list">
                            <?php 
                                \Yii::$app->session->set("count_menuli",1);
                                foreach ($model->childs as $value) {
                                    echo \backend\modules\config\components\MenuLiWidgets::widget(['model'=>$value]);
                                }
                            ?>

                        </ol>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer" style="border-top-color: #ddd;">
                    <?php
                    if (!$model->isNewRecord) {
                        echo Html::a('Xóa menu', ['delete', 'id' => $model->id], ['class' => 'pull-left', 'style' => 'color:red;']);
                        ?>
                        <button type="submit" onclick="$('#submit-form').click();" class="btn btn-primary pull-right">Chỉnh sửa</button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function ()
    {
        $('#nestable').nestable({
            maxDepth: 2
        }).on('change', updateOutput);

    });
</script>