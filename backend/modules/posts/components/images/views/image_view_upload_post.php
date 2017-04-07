
<div class="imageContainer image-view<?= $image->id ?> pull-left" style="margin-left: 10px;margin-bottom: 10px;">
    <div class="imageCenterer">
        <img src="<?= $image->getUrl() ?>" class=" img-responsive img-upload" alt="" >
        <input type="hidden" value="<?= $image->title; ?>" class="name" >
        <input type="hidden" value="<?= date("Y-m-d H:m:i", strtotime($image->create_at)); ?>" class="datetime" >
        <?php if ($image->details): ?>
            <input type="hidden" value='<?= $image->details->value; ?>' class="details" >
        <?php endif; ?>
        <input type="hidden" value='<?= $image->id; ?>' class="id-image" >
        <input type="hidden" value='<?= $image->title; ?>' class="title-image" >
        <input type="hidden" value='<?= $image->description; ?>' class="description-image" >
        <input type="hidden" value='<?= $image->alt; ?>' class="alt-image" >
    </div>
</div>