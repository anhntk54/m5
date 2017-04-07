<li class="<?= $showClass ?>">
    <?= $model->getDisplayName() ?>
    <?php if(count($model->childs) > 0): ?>
        <ul>
            <?php 
            foreach ($model->childs as $value) {
                echo \frontend\modules\Member\components\OneTreeWidgets::widget(['model'=>$value,'count'=>$count]);
            } 
            ?>
        </ul>
    <?php endif;?>
</li>