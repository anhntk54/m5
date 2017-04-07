
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
                <?php $type = ''; ?>
                <?php if ($data): ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?= $title ?></a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tìm kiếm</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="checkbox" style="overflow-y: scroll;height: 100px;background: #eee;padding: 10px;">

                                    <?php foreach ($data as $key): if ($type == '') {
                                            $type = $key->tableName();
                                        } ?>
                                        <label><input type="checkbox" class="checkbox-menu" name="category[]" value="<?= $key->id; ?>"><p><?= $key->title; ?></p></label><br>
                                    <?php endforeach; ?>
                                </div>

                                <div class="add-category" >
                                    <a class="select-all" onclick="" >Chọn tất cả</a>
                                    <button class="btn-default add_to_menu pull-right no-border" data-type="<?= $type ?>">Thêm menu</button>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                    </div>
            <?php else: $type = "linktinh"; ?>
                <div class="add-link-tinh">
                    <div class="form-group no-border">
                        <label>Tên hiển thị</label>
                        <input type="text" name="textname[]" class="form-control input-data-name">
                    </div>
                    <div class="form-group no-border">
                        <label>Url</label>
                        <input type="text" value="" name="textname[]" class="form-control input-data-url">
                    </div>
                    <div class="add-category" >
                        <button class="btn-default add_to_menu pull-right no-border" data-type="<?= $type ?>">Thêm menu</button>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>