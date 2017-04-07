<div class="list-image">
    <ul class="list-unstyled row listSlider">
        <?php 
        foreach ($model as $value){
            echo \backend\modules\posts\components\images\OneImageSliderWidgets::widget(['model'=>$value]);
        } 
        ?>
    </ul>
    
    <div class="clearfix"></div>
</div>
<a  onclick="showPopupImage('#input-form-id-image', '.img-thumbnail-my',1);" id="chonanh">Chọn ảnh đại diện</a>
<script>
    $(document).delegate(".delete i", "click",function (e){
        $(this).parent().parent().remove();
    });
</script>
<style>
    .delete{
        background: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        position: absolute;
        right: 1px;
        display: none;
    }
    .img-slider{
        position: relative;
    }
    .img-slider:hover .delete{
        display: block;
    }
    .img-slider i{
        cursor: pointer;
    }
    .list-image ul{
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
    }
    .list-image ul li {
        width: 32%;
        margin-right: 1%;
        overflow: hidden;
    }
    .list-image ul li:last-child {
        margin-left:0px;
    }
    .img-slider{
        text-align: center;
        max-height: 80px;
        overflow: hidden;
        width: 80px;
        float: left;
        cursor: move;
        border: 1px solid #d5d5d5;
        margin: 9px 9px 0 0;
        background: #f7f7f7;
        border-radius: 2px;
        position: relative;
        box-sizing: border-box;
    }
    .img-slider img{
        height: 100%;
        width: auto;
    }
</style>