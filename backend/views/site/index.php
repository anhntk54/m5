<?php
/* @var $this yii\web\View */

$this->title = backend\models\ConfigApp::getValueConfig("nameApp");
?>

<?php if($run == 0): ?>
<button><a href="<?= \yii\helpers\Url::to(['/config/configapp/begingame']); ?>">Bắt đầu game</a></button>
<?php endif; ?>
