<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/Member/default/resetpassword', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p><?= Yii::t('app', 'EMAIL_SEND_LOST_PASSWORD') ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
