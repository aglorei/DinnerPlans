<div class="tab-pane fade in active" id="dashboard">
	<div class="row">
		<!-- Profile Information -->
		<div class="profile-box col-xs-8 col-md-4">
			<!-- Thumbnail and About Me -->
			<div class="row">
				<div class="col-xs-6">
					<img class="img-thumbnail" src="/assets/images/default_profile.png" alt="/assets/images/default_profile.png">
				</div>
				<div class="col-xs-6">
					<p>A long winded description about my friends and how much I love eating out all the time like that's who I am. I love this a lot.</p>
				</div>
			</div>
			<!-- Upload Photo -->
			<p><a href="#" class="btn btn-block blue" role="button">Upload Profile Picture</a></p>
			<strong><?= $level ?>, registered <?= $days ?> days ago</strong>
			<!-- Update Profile Form -->
			<form id="update-users" action="/users/update/<?= $this->session->userdata('id') ?>" method="post">
				<!-- First Name -->
				<label class="text-muted" for="first_name">First Name:</label>
<?php			if (isset($errors['first_name']))
				{
					echo $errors['first_name'];
				} ?><br>
				<input class="form-control" type="text" name="first_name" value="<?= $first_name ?>" /><br>
				<!-- Last Name -->
				<label class="text-muted" for="last_name">Last Name:</label>
<?php			if (isset($errors['last_name']))
				{
					echo $errors['last_name'];
				} ?><br>
				<input class="form-control" type="text" name="last_name" value="<?= $last_name ?>" /><br>
				<!-- Email Name -->
				<label class="text-muted" for="email">Email:</label>
<?php			if (isset($errors['email']))
				{
					echo $errors['email'];
				} ?><br>
				<input class="form-control" type="text" name="email" value="<?= $email ?>" /><br>

				<!-- Submit Form -->
				<input class="btn btn-block blue" type="submit" value="Update Profile Information" />
			</form>
		</div>
	</div>
</div>