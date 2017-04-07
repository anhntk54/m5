<?php
use common\models\M5;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $member->getAvatar() ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $member->getDisplayName() ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
\
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                "items" => [
                    ["label" =>'MAIN NAVIGATION', 'options' => ['class' => 'header']],
                    ["label" =>Yii::t('app', 'MENU_HOME'), "url" => "/", "icon" => "fa fa-dashboard"],
                    ["label" =>Yii::t('app', 'MENU_REGISTER'), "url" => ["/M5/default/give"], "icon" => "fa fa-money"],
                    ["label" =>Yii::t('app', 'MENU_LIST_PD'), "url" => ["/M5/default/list/"], "icon" => "fa fa-mail-forward"],
                    [
                        "label" =>Yii::t('app', 'MENU_LIST_GD'),
                        "icon" => "fa fa-mail-reply",
                        "url" =>  ['/M5/default/listtake/'],
                        'active'=>''
                    ],
                    [
                        "label" => Yii::t('app', 'MENU_PIN'),
                        "url" => ['/M5/pin/create/'],
                        "icon" => "fa fa-unlock-alt ",
                    ],
                    [
                        "label" => Yii::t('app', 'MENU_ROSES'),
                        "url" => "#",
                        "icon" => "fa fa-coffee",
                        "items" => [
                            [
                                "label" => Yii::t('app', 'MENU_ROSES_REGISTER'),
                                "url" => ['/M5/roses/create'],
                                "icon" => 'fa fa-circle-o'
                            ],
                            [
                                "label" => Yii::t('app', 'MENU_ROSES_LIST'),
                                "url" => ['/M5/roses/'],
                                "icon" => 'fa fa-circle-o'
                            ],
                        ],
                    ],
                    ["label" =>Yii::t('app', 'TOP_CREATE_USER'), "url" => ["/Member/default/create"], "icon" => "fa fa-user-plus"],
                    ["label" =>Yii::t('app', 'MENU_MEMBER_TREE'), "url" => ["/Member/default/tree"], "icon" => "fa fa-street-view"],
                    ["label" =>Yii::t('app', 'MENU_INFO_PROFILE'), "url" => ["/Member/default/index"], "icon" => "fa fa-user"],
                    ["label" =>Yii::t('app', 'TOP_LOGOUT'), "url" => ["/Member/default/logout"], "icon" => "fa fa-sign-out"],
                ],
            ]
        ) ?>

    </section>

</aside>
