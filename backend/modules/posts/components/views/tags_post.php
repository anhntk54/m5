
<div class="col-md-4 pull-right">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Tags bài viết</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
<!--            <select multiple="true" name="choose_usr_email[]" id="choose_usr_email" class="form-control select2">
                 if tags are loaded over AJAX, no need for <option> elments 
            </select>-->
            <textarea id="demo2" name="tags"><?= $s; ?></textarea>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<script>

    window.onload = function () {
        jQuery(document).on('keypress', '#w0', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13 && !jQuery(e.target).is('textarea#demo2')) {
                e.preventDefault();
                return false;
            }
        });
        $('#demo2').tagEditor({
            autocomplete: {delay: 0, position: {collision: 'flip'},
                source: function (request, response) {
                    $.ajax({
                        dataType: "json",
                        type: 'Post',
                        url: '<?= yii\helpers\Url::to("?r=posts/tags/searchtagspost"); ?>',
                        data:{term:request.term},
                        success: function (data) {
                            console.log(request.term);
//                $('input.suggest-user').removeClass('ui-autocomplete-loading');  
                            // hide loading image

                            response(data);
                        },
                        error: function (data) {
                            $('input.suggest-user').removeClass('ui-autocomplete-loading');
                        }
                    });
                },
            },
            forceLowercase: false,
            placeholder: 'Lựa chọn tags'
        });

    }

</script>