<tr>
    <td class="mailbox-name"><a href="#"><?= $model->memberaction ? $model->memberaction->getDisplayName() : '' ?></a></td>
    <td class="mailbox-subject"><?= $model->getTitle(); ?>
    </td>
    <td class="mailbox-attachment"></td>
    <td class="mailbox-date"><?= $model->getTime(); ?></td>
</tr>