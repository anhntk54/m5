
    <div class = "col-md-8 no-margin" style="height: 400px;padding-top: 20px;">
        <div class="listImage">

        </div>
    </div>
    <div class="imagesdetails col-md-4 no-margin no-padding" style="background: #eeeeee;border-radius: 0px; padding-right: 0px;height: 400px;">
        <div class = "panel-body" style="padding:20px;">
            <?= \backend\modules\posts\components\images\DetailsImageUploadWidgets::widget(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<style type="text/css">
    .listImage{
        overflow-y: auto;
        height: 392px;
    }
    .imageContainer {
        width: 150px;
        height: 100px;
        overflow: hidden;
        position: relative;
    }
    .imageCenterer {
        width: 1000px;
        /*position: absolute;*/
        left: 50%;
        top: 0;
        margin-left: -500px;
    }
    .imageCenterer img {
        display: block;
        margin: 0 auto;
        max-width: 100%;
        margin:auto;
        position:absolute;
        top:0; left:0; right:0; bottom:0;
    }
    .img-chon {
        border: 4px solid #3769ce;
    }
    .img-chon-e {
        border: 4px solid #aaa;
    }
</style>