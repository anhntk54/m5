<?php
use yii\helpers\Url;
$this->title = 'Danh sách mã pin';
$this->params['breadcrumbs'][] = $this->title;
?>
<a href="<?= Url::to(['/M5/default/givepin']) ?>">Cấp mã pin</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã Pin</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $value): ?>
            <?php
            $statusText = $value->getStatus()[$value->status];
            ?>

            <tr>
                <td><?= $value->code; ?></td>
                <td><?= $statusText; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>