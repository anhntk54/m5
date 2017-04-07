<li>
    <a href="#">
        <div class="pull-left">
            <?php if ($model->memberaction): ?>
                <?= $model->memberaction->getHtmlAvatar(['class'=>'img-circle']) ?>
            <?php endif; ?>
        </div>
        <h4>
            <?= $model->memberaction ? $model->memberaction->getDisplayName() : '' ?>
            <small><i class="fa fa-clock-o"></i> <?= $model->getTime(); ?></small>
        </h4>
        <span class="messagelog"><?= $model->getTitle(); ?></span>
    </a>
</li>
