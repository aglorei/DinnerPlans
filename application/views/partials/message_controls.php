<div class="tab-pane fade in active" id="dashboard">
	<div class="row">
		<div class="col-xs-12 col-sm-3">
			<!-- Tab Selectors -->
			<ul class="nav nav-stacked nav-tabs" role="tablist">
				<li id="inbox-tab" role="presentation"><a href="#inbox" data-toggle="tab">Inbox</a></li>
				<li id="sent-tab" role="presentation"><a href="#sent" data-toggle="tab">Sent</a></li>
				<li id="compose-tab" role="presentation"><a href="#compose" data-toggle="tab">Compose</a></li>
			</ul>
		</div>
		<div class="col-xs-12 col-sm-9">
			<!-- Tab Contents -->
			<div class="tab-content">
				<!-- Inbox -->
				<div class="tab-pane fade in" id="inbox">
<?php				foreach ($inbox as $mail)
					{ ?>
						<div class="mail-box">
							<h4>From: <span class="text-muted"><?= $mail['from_user'] ?></span></h4>
							<h4>To: <span class="text-muted"><?= $mail['to_user'] ?></span></h4>
							<p class="text-muted"><?= $mail['message'] ?></p>

							<!-- Reply -->
							<form class="send-mail" action="/messages/send/<?= $this->session->userdata('id') ?>" method="post">
								<!-- Hidden 'to' Field -->
								<input type="hidden" name="to" value="<?= $mail['from_user'] ?>">
								<!-- Message -->
								<label class="text-muted" for="message">Reply:</label>
<?php							if (isset($errors['message']))
								{
									echo $errors['message'];
								} ?>
								<textarea class="form-control" name="message"></textarea>
								<!-- Submit Form -->
								<input class="btn blue" type="submit" value="Reply" />
							</form>
						</div>
<?php				} ?>
				</div>
				<!-- Sent -->
				<div class="tab-pane fade in" id="sent">
<?php				foreach ($sent as $mail)
					{ ?>
						<div class="mail-box">
							<h4>From: <span class="text-muted"><?= $mail['from_user'] ?></span></h4>
							<h4>To: <span class="text-muted"><?= $mail['to_user'] ?></span></h4>
							<p class="text-muted"><?= $mail['message'] ?></p>
						</div>
<?php				} ?>
				</div>
				<!-- Compose -->
				<div class="tab-pane fade in" id="compose">
					<div class="mail-box">
<?php					$this->load->view('partials/message_form'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>