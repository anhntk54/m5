<li class="img-slider col-sm-4">
    <input class="hidden" name="slider[]" value="<?= $value->id; ?>"/>
    <div class="delete"><i class="fa fa-times" aria-hidden="true"></i></div>
    <img src="<?= $value->getUrl(150) ?>" />
</li>