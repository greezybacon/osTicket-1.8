<?php
if (!$info['title'])
    $info['title'] = Format::htmlchars($org->getName());
?>
<h3><?php echo $info['title']; ?></h3>
<b><a class="close" href="#"><i class="fa fa-times-circle-o"></i></a></b>
<hr/>
<?php
if ($info['error']) {
    echo sprintf('<p id="msg_error">%s</p>', $info['error']);
} elseif ($info['msg']) {
    echo sprintf('<p id="msg_notice">%s</p>', $info['msg']);
} ?>
<div id="org-profile" style="display:<?php echo $forms ? 'none' : 'block'; ?>;margin:5px;">
    <i class="fa fa-group fa-4x pull-left fa-border"></i>
    <?php
    if ($account) { ?>
    <a class="action-button pull-right user-action" style="overflow:inherit"
        href="#users/<?php echo $account->getUserId(); ?>/org/<?php echo $org->getId(); ?>" ><i class="fa fa-user"></i> Change Organization</a>
    <?php
    } ?>
    <div><b><a href="#" id="editorg"><i class="fa fa-edit"></i>&nbsp;<?php
    echo Format::htmlchars($org->getName()); ?></a></b></div>
    <table style="margin-top: 1em;">
<?php foreach ($org->getDynamicData() as $entry) {
?>
    <tr><td colspan="2" style="border-bottom: 1px dotted black"><strong><?php
         echo $entry->getForm()->get('title'); ?></strong></td></tr>
<?php foreach ($entry->getAnswers() as $a) { ?>
    <tr style="vertical-align:top"><td style="width:30%;border-bottom: 1px dotted #ccc"><?php echo Format::htmlchars($a->getField()->get('label'));
         ?>:</td>
    <td style="border-bottom: 1px dotted #ccc"><?php echo $a->display(); ?></td>
    </tr>
<?php }
}
?>
    </table>
    <div class="clear"></div>
    <hr>
    <div class="faded">Last updated <b><?php echo Format::db_datetime($org->getUpdateDate()); ?> </b></div>
</div>
<div id="org-form" style="display:<?php echo $forms ? 'block' : 'none'; ?>;">
<div><p id="msg_info"><i class="fa fa-info-circle"></i>&nbsp; Please note that updates will be reflected system-wide.</p></div>
<?php
$action = $info['action'] ? $info['action'] : ('#orgs/'.$org->getId());
if ($ticket && $ticket->getOwnerId() == $user->getId())
    $action = '#tickets/'.$ticket->getId().'/user';
?>
<form method="post" class="org" action="<?php echo $action; ?>">
    <input type="hidden" name="id" value="<?php echo $org->getId(); ?>" />
    <table width="100%">
    <?php
        if (!$forms) $forms = $org->getForms();
        foreach ($forms as $form)
            $form->render();
    ?>
    </table>
    <hr>
    <p class="full-width">
        <span class="buttons" style="float:left">
            <input type="reset" value="Reset">
            <input type="button" name="cancel" class="<?php
    echo $account ? 'cancel' : 'close'; ?>"  value="Cancel">
        </span>
        <span class="buttons" style="float:right">
            <input type="submit" value="Update Organization">
        </span>
     </p>
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function() {
    $('a#editorg').click( function(e) {
        e.preventDefault();
        $('div#org-profile').hide();
        $('div#org-form').fadeIn();
        return false;
     });

    $(document).on('click', 'form.org input.cancel', function (e) {
        e.preventDefault();
        $('div#org-form').hide();
        $('div#org-profile').fadeIn();
        return false;
     });
});
</script>
