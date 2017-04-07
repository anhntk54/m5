<?php
$idimage = 0;
if ($model->image) {
    $idimage = $model->image->id;
}
?>
<input type="hidden" value="<?= $idimage ?>" name="idimage" id="input-form-id-image" />
<div class="col-md-12">
    <?php
    $xoaanh = '';
    $chonanh = '';
    $src = '';
    if ($model->image) {
        $chonanh = 'display: none;';
        $src = $model->image->getUrl();
    } else {
        $xoaanh = 'display: none;';
    }
    ?>
    <img src="<?= $src; ?>" class="img-thumbnail img-thumbnail-my"/>
</div>
<a style="<?= $chonanh ?>" onclick="showPopupImage('#input-form-id-image', '.img-thumbnail-my');" id="chonanh">Chọn ảnh đại diện</a>
<a style="<?= $xoaanh ?>" onclick="$('.img-thumbnail').attr('src', '');$('#input-form-id-image').val(0); $('#chonanh').show();$('#xoaanh').hide();" id="xoaanh">Xóa ảnh</a>
