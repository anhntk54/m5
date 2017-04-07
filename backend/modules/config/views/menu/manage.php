<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\config\models\Menu;
/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\MenuSearch */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Quản lý menu";
?>

<div class="menu-search">
    <h1 class="col-md-4"><?= Html::encode($this->title) ?> <?= Html::a('Tất cả', ['index'], ['class' => 'btn btn-success']) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php
                    $form = ActiveForm::begin();
                    ?>
                    <div class="form-group col-md-12">
                        <p class="col-md-2" style="padding: 7px;"><label>Menu header</label></p>
                        <div class="col-md-4">
                            <?= Html::activeDropDownList($model, 'header_menu', ArrayHelper::map(Menu::find()->where(['parent_id' => 0])->all(), "id", "name"), ["class" => "form-control", "prompt" => "Chọn menu"]) ?>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="col-md-2" style="padding: 7px;"><label>Menu footer</label></p>
                        <div class="col-md-4">
                            <?= Html::activeDropDownList($model, 'footer_menu', ArrayHelper::map(Menu::find()->where(['parent_id' => 0])->all(), "id", "name"), ["class" => "form-control", "prompt" => "Chọn menu"]) ?>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <p class="col-md-2" style="padding: 7px;"><label>Menu sidebar</label></p>
                        <div class="col-md-4">
                            <?= Html::activeDropDownList($model, 'sidebar_menu', ArrayHelper::map(Menu::find()->where(['parent_id' => 0])->all(), "id", "name"), ["class" => "form-control", "prompt" => "Chọn menu"]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
