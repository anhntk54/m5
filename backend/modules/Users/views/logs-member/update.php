<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogsMemberSql */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Logs Member Sql',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs Member Sqls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="logs-member-sql-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
