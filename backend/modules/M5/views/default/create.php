<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\M5 */

$this->title = Yii::t('app', 'Create M5');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'M5s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m5-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
