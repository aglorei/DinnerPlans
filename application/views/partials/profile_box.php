	<!-- Profile Information -->
	<div class="profile-box col-xs-8 col-sm-6 col-md-4">
		<!-- Thumbnail and About Me -->
		<img class="img-thumbnail" src="<?= $file_path ?>" alt="/assets/images/default_profile.png">
		<!-- Upload Photo -->
<?php	if (isset($errors['upload']))
		{
			echo $errors['upload'];
		} ?>
		<form class="upload-picture" action="/users/upload_picture" enctype="multipart/form-data" method="post">
			<div class="file-upload btn blue">
				<span>Browse</span><input type="file" name="userfile" size="10" />
			</div>
			<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
			<input class="form-control btn btn-block blue" type="submit" value="Upload Picture" />
		</form>
		<!-- Registration Date -->
		<strong><?= $level ?>, registered <?= $days ?> days ago</strong>
		<!-- Update Profile Form -->
		<form class="update-users" action="/users/update/<?= $id ?>" method="post">
			<!-- First Name -->
			<label class="text-muted" for="first_name">First Name:</label>
<?php		if (isset($errors['first_name']))
			{
				echo $errors['first_name'];
			} ?>
			<input class="form-control" type="text" name="first_name" value="<?= $first_name ?>" />
			<!-- Last Name -->
			<label class="text-muted" for="last_name">Last Name:</label>
<?php		if (isset($errors['last_name']))
			{
				echo $errors['last_name'];
			} ?>
			<input class="form-control" type="text" name="last_name" value="<?= $last_name ?>" />
			<!-- Email -->
			<label class="text-muted" for="email">Email:</label>
<?php		if (isset($errors['email']))
			{
				echo $errors['email'];
			} ?>
			<input class="form-control" type="text" name="email" value="<?= $email ?>" />
			<!-- Description -->
			<label class="text-muted" for="description">Description:</label>
<?php		if (isset($errors['description']))
			{
				echo $errors['description'];
			} ?>
			<textarea class="form-control" name="description" placeholder="A long winded description about my friends and how much I love eating out all the time like that's who I am. I love this a lot."><?= $description ?></textarea>

			<!-- Submit Form -->
			<input class="form-control btn btn-block blue" type="submit" value="Update Profile" />
		</form>
	</div>