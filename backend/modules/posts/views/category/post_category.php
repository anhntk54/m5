
<option value="">Danh mục cha</option>
<?php foreach ($categories as $value):?>
<option value="<?= $value->id ?>"><?= $value->title ?></option>
<?php endforeach;?>