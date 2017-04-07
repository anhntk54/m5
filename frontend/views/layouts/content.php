<?php 
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo $this->title ?>
      </h1>
      <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
</section>

    <section class="content">

        <?= Alert::widget() ?>
        <?= $content ?>

    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2016 M5.</strong> All rights
    reserved.
</footer>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>