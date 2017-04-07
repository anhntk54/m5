<?php

use common\models\M5;
?>
<!-- start user projects -->
<table class="data table table-striped no-margin">
    <thead>
        <tr>
            <th>#</th>
            <th><?= $type == M5::TYPE_GIVE ? "Người nhận" : "Người gửi"; ?></th>
            <th>Tiền</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($model) > 0): ?>
            <?php foreach ($model as $value): ?>
                <?php
                $statusText = $value->getStatusText();
                ?>

                <tr>
                    <td><?= $value->id; ?></td>
                    <td><?= $type == M5::TYPE_GIVE ? $value->membertake->username : $value->membergive->username; ?></td>
                    <td><?= $value->money; ?></td>
                    <td><?= $statusText; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">Không tìm thấy dòng nào phù hợp</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<!-- end user projects -->