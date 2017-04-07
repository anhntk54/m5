<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\posts\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12 no-padding">
        <div class="box box-primary">
            <div class="box-header">
                <?=  $model->isNewRecord ? '':$form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                 <div class="col-md-4 form-group">
                    <label class="control-label" for="category-title">Ảnh đại diện</label>
                    <?= \backend\modules\posts\components\images\SelectImageWidgets::widget(['model'=>$model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= backend\modules\posts\components\SeoPostWidgets::widget(['model' => $model, 'form' => $form]); ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
<?= backend\modules\posts\components\images\UpImageWidgets::widget(); ?>
</div>
