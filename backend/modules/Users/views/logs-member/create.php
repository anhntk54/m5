<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogsMemberSql */

$this->title = Yii::t('app', 'Create Logs Member Sql');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Logs Member Sqls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-member-sql-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
