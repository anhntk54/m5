<?php
use common\models\M5;
use yii\helpers\Url;
use common\func\FunctionCommon;
use common\models\Cycle;
use common\models\Transactions;
$this->title = Yii::t('app', 'VIEW_MEMBER_TITLE');
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
    $percentRoses =$countRoses / $model->level->count_roses;
}
?>
<!-- page content -->
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title; ?></h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= Yii::t('app', 'VIEW_MEMBER_ALL_INFO') ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <img class="img-responsive avatar-view" src="<?= $model->getAvatar() ?>" alt="Avatar" title="Change the avatar">
                            </div>
                        </div>
                        <h3><?= $model->getDisplayName() ?></h3>

                        <ul class="list-unstyled user_data">
                            <li><i class="fa fa-mobile"></i> <?= $model->mobile ?></li>

                            <li>
                                <i class="fa fa-envelope-o"></i> <?= $model->email ?>
                            </li>

                            <li class="m-top-xs">
                                <i class="fa fa-external-link user-profile-icon"></i>
                                <a href="<?= $link; ?>" target="_blank">Link giới thiệu</a>
                            </li>
                        </ul>

                        <a class="btn btn-success" href="<?= $linkChangeInfo; ?>"><i class="fa fa-edit m-right-xs"></i><?= Yii::t('app', 'VIEW_MEMBER_EDIT_MEMBER') ?></a>
                        <br />

                        <!-- start skills -->
                        <h4><?= Yii::t('app', 'VIEW_MEMBER_CYCLE_COUNT').':'.$countCycle; ?></h4>
                        <ul class="list-unstyled user_data">
                            <li><p> <?= Yii::t('app', 'VIEW_MEMBER_LEVER_CURRENT').':'.$level ?></p></li>
                            <li><p> <?= Yii::t('app', 'VIEW_MEMBER_ROSES_CURRENT').':'.$moneyRoses ?></p></li>
                            <li><p> <?= Yii::t('app', 'VIEW_MEMBER_COUNT_PIN').':'.count($model->pins); ?></p></li>
                            <li>
                                <p><?= Yii::t('app', 'VIEW_MEMBER_PD_COUNT').':'.$countPD; ?></p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= $percentPd * 100; ?>" style="width: <?= $percentPd * 100; ?>%;"></div>
                                </div>
                            </li>
                            <li>
                                <p> <?= Yii::t('app', 'VIEW_MEMBER_ROSES_COUNT').':'.$countRoses; ?></p>
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= $percentRoses * 100; ?>" style="width: <?= $percentRoses * 100; ?>%;"></div>
                                </div>
                            </li>
                        </ul>
                        <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Giao dịch GD</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Giao dịch PD</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Hoa hồng</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_TAKE]) ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_GIVE]) ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                    <?= frontend\modules\M5\components\HomeTableWidgets::widget(['type'=>  M5::TYPE_TAKE_ROSES]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->