<script type="text/javascript" src="http://nhadathd.vl/css/macKeys.js"></script>
<button type="button" class="btn btn-primary img-upload-my " style="display: none;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">UP Images</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;height: 95%;">
        <div class="modal-content" style="height: 92%;">
            <div class="modal-header no-border" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-close-upimage">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Thư viện ảnh</h4>
            </div>
            <div class="modal-body" style="padding: 7px;">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-target="#home" data-toggle="tab">Tải ảnh</a></li>
                    <li><a data-target="#profile" data-toggle="tab">Danh sách ảnh</a></li>
                </ul>

                <div class="tab-content" style="height: 392px;">
                    <div class="tab-pane active select-input" id="home">
                        <div id="uploadFormLayer" style="height: 400px;">
                            <form id="uploadForm" action="upload.php" method="post">
                                <input name="userImage" type="file" class="inputFile" style="display: none;" />
                                <button type="button" class="btn btn-default" onclick="$('.inputFile').click(); return;">Chọn ảnh</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile">
                        <div class="tab-2 row no-margin row">
                            <?= backend\modules\posts\components\images\ListImageWidgets::widget(); ?>

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer" style="border-top-color: #ddd;">
                <button type="button" class="btn btn-primary disabled" style="margin-top: -5px;" id="select-image">Chọn ảnh</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    var setidImage = "";
    var setUrlImage = "";
    var slider = 0;
    function showPopupImage(sid, surl,_slider = 0) {
        setUrlImage = surl;
        setidImage = sid;
        slider = _slider;
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/posts/images/getimage']); ?>",
            type: "POST",
            data: {},
            success: function (data)
            {
                $('.listImage').html(data);
                $('.img-upload-my').click();
            },
        });
    }
    $('input[type="file"]').change(function () {
        $("#uploadForm").submit();

    });
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('.image-view').removeClass("img-bordered");
        $('#select-image').addClass("disabled");
        $('.div-details-image').hide();
    })
    $("#uploadForm").on('submit', (function (e) {
        e.preventDefault();
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/posts/images/postimages']); ?>",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data)
            {
                jQuery('#myTab a:last').tab('show');
                $('.listImage').prepend(data);
                document.getElementById('uploadForm').reset();
            },
        });
    }));
    $(document).delegate(".delete-attachment", "click", function () {
        if (confirm("Bạn có xóa ảnh này?")) {
            var tid = $(this).parent().find('.id-image').val();
            $.ajax({
                url: "<?= yii\helpers\Url::to(["/posts/images/delete"]); ?>"+"?id=" + tid,
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    $('.image-view' + data).remove();
                    $('.div-details-image').hide();
                },
                error: function ()
                {
                }
            });
        }
    });
    $(document).delegate(".img-upload", "click", function (event) {
        if (!event.ctrlKey && !macKeys.cmdKey && slider == 1) {
            $('.imageContainer .img-chon').addClass("img-chon-e");
            $('.imageContainer').removeClass("img-chon");
        }
        
        $(this).parent().parent().addClass("img-chon");
        $('.details-image').attr('src', $(this).attr('src'));
        var details = JSON.parse($(this).parent().find('.details').val());
        var title = $(this).parent().find('.name').val();
        $('.details-div-images .filename').html(title);
        $('.details-div-images .uploaded').html($(this).parent().find('.datetime').val());
        $('.details-div-images .dimensions').html(details['width'] + " x " + details['height']);
        $('.details-div-images .file-size').html(details['size']);
        $('.details-div-images .id-image').val($(this).parent().find('.id-image').val());
        $('.div-details-image').show();
        $('#input-title-image').val($(this).parent().find('.title-image').val());
        $('#input-id-image').val($(this).parent().find('.id-image').val());
        $('#input-alt-image').val($(this).parent().find('.alt-image').val());
        $('#input-description-image').val($(this).parent().find('.description-image').val());
        $('#select-image').removeClass("disabled");
    });
    $('#select-image').click(function () {
        var arrId = [];
        if (slider == 1) {
            $.each($('.img-chon .imageCenterer'),function (key,value){
                arrId.push($(value).find('.id-image').val());
            });
        }
        $.ajax({
            url: "<?= yii\helpers\Url::to(['/posts/images/saveimage']); ?>",
            type: "POST",
            data: {title_image: $('#input-title-image').val(), alt_image: $('#input-alt-image').val(), id_image: $('#input-id-image').val(), description_image: $('#input-description-image').val(),
                   listID: arrId
                    },
            success: function (data)
            {
                var json = JSON.parse(data);
                if (json != null) {
                    if (json.status == 'i') {
                        $(setUrlImage).attr('src', json.urlimage);
                        $(setidImage).val(json.id);
                        $('#chonanh').hide();
                        $('#xoaanh').show();
                    }else{
                        console.log("co vao day k");
                        $('.listSlider').html(json.html);
                    }
                    $('#btn-close-upimage').click();
                }
            },
        });
    });
</script>
<style>
    .pa-upload-details{padding-left: 10px;margin-right:10px;width: 70%;}
    .div-from-upload{height: 48px;}
    .modal-dialog,
    .modal-content {
        /* 80% of window height */
        height: 92%;
    }
    #home{position: relative;}
    #uploadForm{
        position: absolute;
        top: 180px;
        left: 400px;
    }
    #uploadForm>button{
        width: 200px;
        font-size: 24px;
    }
</style>