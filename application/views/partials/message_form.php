<form class="send-mail" action="/messages/send/<?= $this->session->userdata('id') ?>" method="post">
	<!-- From -->
	<label class="text-muted" for="from">From:</label>
	<input class="form-control" type="text" value="<?= $this->session->userdata('first_name').' '.$this->session->userdata('last_name') ?>" disabled/>

	<!-- To -->
	<label class="text-muted" for="from">To:</label>
<?php	if (isset($errors['to']))
		{
			echo $errors['to'];
		} ?>
	<input class="form-control" type="text" name="to" />

	<!-- Message -->
	<label class="text-muted" for="message">Message:</label>
<?php	if (isset($errors['message']))
		{
			echo $errors['message'];
		} ?>
	<textarea class="form-control" name="message"></textarea>

	<!-- Submit Form -->
	<input class="btn blue" type="submit" value="Send" />
</form>