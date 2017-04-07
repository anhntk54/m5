<?php

use common\models\M5;
use yii\helpers\Url;
use common\func\FunctionCommon;
use common\models\Cycle;
use common\models\Transactions;

$this->title = Yii::t('app', 'VIEW_MEMBER_TITLE');
$this->params['breadcrumbs'][] = $this->title;
$link = Yii::$app->urlManager->createAbsoluteUrl(['/Member/default/signup', 'key' => $model->key_member]);
$linkChangeInfo = Url::to(['/Member/default/changeinfo']);
$moneyRoses = FunctionCommon::formatMoney($model->money_roses);
$countPD = count($model->givecycle);
$percentRoses = 0;
$percentPd = 0;
$cycle = Cycle::current();
$countCycle = Cycle::find()->count();
$level = $model->level ? $model->level->name : 0;
if ($cycle && $cycle->max > 0) {
    $percentPd = $countPD / $cycle->max;
}
$countRoses = Transactions::getCountOfWeek($model);
if ($model->level && $model->level->count_roses > 0) {
    $percentRoses = $countRoses / $model->level->count_roses;
}
list(, $url) = Yii::$app->assetManager->publish('@webroot/js');
$this->registerJsFile($url . '/copyInput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $model->getAvatar() ?>" alt="User profile picture">

                <h3 class="profile-username text-center"><?= $model->getDisplayName() ?></h3>

                <p class="text-muted text-center"><?= $model->username ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b><?= Yii::t('app', 'VIEW_MEMBER_ROSES_CURRENT') ?></b> <a class="pull-right"><?= $moneyRoses ?></a>
                    </li>
                    <li class="list-group-item">
                        <b><?= Yii::t('app', 'VIEW_MEMBER_COUNT_PIN') ?></b> <a class="pull-right"><?= $model->pin ?></a>
                    </li>
                    <li class="list-group-item">
                        <b><?= Yii::t('app', 'VIEW_MEMBER_LEVER_CURRENT') ?></b> <a class="pull-right"><?= $level ?></a>
                    </li>
                </ul>

                <button href="#" class="btn btn-primary btn-block" id="copy-link" data-toggle="popover" data-placement="bottom" data-content="<?= Yii::t('app','MEMBER_CHANGE_INFO_COPY_LINK') ?>"><b><?= Yii::t('app', 'MEMBER_PROFILE_LINK_SIGNUP') ?></b></button>
                <input type="text" value="<?= $link ?>" style="position: absolute;top: -50000px;" id="input_copy_link">
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app', 'VIEW_MEMBER_CYCLE_COUNT') . ':' . $countCycle; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-line-chart margin-r-5"></i> <?= Yii::t('app', 'VIEW_MEMBER_PD_COUNT') . ':' . $countPD ?></strong>

                <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= $percentRoses * 100; ?>" style="width: <?= $percentRoses * 100; ?>%;"></div>
                </div>

                <hr>

                <strong><i class="fa fa-money margin-r-5"></i> <?= Yii::t('app', 'VIEW_MEMBER_ROSES_COUNT') . ':' . $countRoses; ?></strong>

                <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= $percentRoses * 100; ?>" style="width: <?= $percentRoses * 100; ?>%;"></div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab"><?= Yii::t('app', 'VIEW_LIST_TITLE_PD') ?></a></li>
                <li><a href="#timeline" data-toggle="tab"><?= Yii::t('app', 'VIEW_LIST_TITLE_GD') ?></a></li>
                <li><a href="#settings" data-toggle="tab"><?= Yii::t('app', 'MENU_ROSES') ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_TAKE]) ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_GIVE]) ?>
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="settings">
                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_TAKE_ROSES]) ?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>