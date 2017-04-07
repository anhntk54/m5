<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogsMember */

$this->title = Yii::t('app', 'Create Logs Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
