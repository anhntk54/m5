<?php
$url = '';
$checked = '';
$idvalue = 0;$id = 0;
if ($model->new_tab == 1) {
    $checked = "checked ='check'";
}
$nametype = $model->table_name;
if ($model->table_name == 'linktinh') {
    $url = $model->value;
    $nametype ="Link tĩnh";
} else {
    $idvalue = $model->value;
}
if (\Yii::$app->session->get("count_menuli") != NULL) {
    $id = \Yii::$app->session->get("count_menuli");
    $i = $id + 1;
    \Yii::$app->session->set("count_menuli",$i);
}
?>
<li class="dd-item" data-id="<?= $id ?>" data-idpost="<?= $idvalue ?>" data-type="<?= $model->table_name ?>" data-name="<?= $model->name ?>"  data-url="<?= $url ?>" data-new="0" data-newtab="0">
    <div class="dd-handle"><?= $model->name ?></div>
    <span class="button-edit pull-right" data-owner-id="<?= $id ?>">
        <p class="titleli"><?= $nametype ?></p>
        <i class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></i>
    </span>
    <div class="box no-border edit-form" style="margin-top: -5px;">
        <div class="box-body" style="display: block;">
            <div class="col-md-12 no-padding">
                <div class="form-group no-border">
                    <label>Tên hiển thị</label>
                    <input type="text" name="textname[]" data-owner-id="<?= $id ?>" value="<?= $model->name ?>" class="form-control input-data-name">
                </div>
                <?php if ($url != ''): ?>
                    <div class="form-group no-border">
                        <label>Url</label>
                        <input type="text" value="<?= $url ?>" data-owner-id="<?= $id ?>" name="textname[]" class="form-control input-data-url">
                    </div>
                <?php endif; ?>
                <div class="checkbox">
                    <label><input type="checkbox" <?= $checked ?> value="" data-owner-id="<?= $id ?>" class="input-data-tab">Mở tab mới</label>
                </div>
                <div class="no-border">
                    <a class="button-delete" data-owner-id="<?= $id ?>">Xóa</a>
                </div>
            </div>
        </div>

    </div>
    <?php if (count($model->childs) > 0): ?>
        <ol class="dd-list">
            <?php
            foreach ($model->childs as $value) {
                echo \backend\modules\config\components\MenuLiWidgets::widget(['model' => $value]);
            }
            ?>
        </ol>
    <?php endif; ?>
</li>
