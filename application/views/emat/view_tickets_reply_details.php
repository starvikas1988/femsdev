<form method="POST" action="<?php echo base_url('emat/send_ticket_reply'); ?>" autocomplete="off" enctype="multipart/form-data">
<div class="row">

<div class="col-md-12">
<div class="form-group">
	<label>Reply To</label>
	<input type="text" class="form-control" name="reply_to" value="<?php echo $messageList['ticket_email_from']; ?>" required>
	<input type="hidden" class="form-control" name="reply_from" value="<?php echo $messageList['ticket_email']; ?>" required>
	<input type="hidden" class="form-control" name="reply_from_name" value="<?php echo $messageList['ticket_email_from_name']; ?>" required>
	<input type="hidden" class="form-control" name="ticket_no" value="<?php echo $messageList['ticket_no']; ?>" required>
	<input type="hidden" class="form-control" name="message_id" value="<?php echo $messageList['ticket_message_id']; ?>" required>
	<input type="hidden" class="form-control" name="message_references" value="<?php echo $messageList['e_references']; ?>" required>
	<input type="hidden" class="form-control" name="piping_mail_id" value="<?php echo $messageList['ticket_email_ref_id']; ?>" required>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
	<label>Subject</label>
	<input type="text" class="form-control" name="message_subject" value="<?php echo $messageList['email_subject']; ?>" required>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
	<label>Message</label>
	<textarea class="form-control" id="moreInfoEditor" name="message_body" required></textarea>
</div>
</div>

<div class="col-md-12">
<div class="form-group">
	<button type="submit" class="btn btn-danger">Reply</button>
</div>
</div>

</div>
</form>