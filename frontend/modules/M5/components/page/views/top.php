
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Config;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">M5</span><span class="logo-lg">' . Config::getValueConfig('nameApp') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <?= frontend\modules\M5\components\logs\LogsWidgets::widget() ?>
                
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $member->getAvatar() ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php echo $member->getDisplayName(); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $member->getAvatar() ?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= $member->getDisplayName(); ?>
                                <small><?= sprintf(Yii::t('app', 'MEMBER_DATE_CREATE_AT'),  date('m-Y',  strtotime($member->created_at))); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="<?= Url::to(['/Member/default/changeinfo']) ?>"><?= Yii::t('app', 'TOP_CHANGE_INFO'); ?></a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="<?= Url::to(['/Member/default/changepassword']) ?>">
                                    <span><?= Yii::t('app', 'TOP_CHANGE_PASSWORD'); ?></span>
                                </a>
                                </div>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to(['/Member/default/create']) ?>" class="btn btn-success btn-flat"><?= Yii::t('app', 'TOP_CREATE_USER'); ?></a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('app', 'TOP_LOGOUT'),
                                    ['/Member/default/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
