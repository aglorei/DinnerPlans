<div class="tab-pane fade in active" id="dashboard">
<?php	foreach ($users as $user)
		{ ?>
		<div class="row">
			<!-- Profile Information -->
			<div class="profile-box col-sm-12 col-md-4">
				<!-- Thumbnail and About Me -->
				<img class="img-thumbnail" src="<?= $user['file_path'] ?>" alt="/assets/images/default_profile.png">
				<!-- Upload Photo -->
<?php			if (isset($errors['upload']))
				{
					echo $errors['upload'];
				} ?>
				<form class="upload-picture" action="/users/upload_picture/<?= $user['id'] ?>" enctype="multipart/form-data" method="post">
					<div class="file-upload btn blue">
						<span>Browse</span><input type="file" name="userfile" size="10" />
					</div>
					<input id="uploadFile" placeholder="Choose File" disabled="disabled" />
					<input class="form-control btn btn-block blue" type="submit" value="Upload Picture" />
				</form>
			</div>
			<div class="profile-box col-sm-12 col-md-4">
				<!-- Update Profile Form -->
				<form class="update-users" action="/users/update/<?= $user['id'] ?>" method="post">
					<!-- First Name -->
					<label class="text-muted" for="first_name">First Name:</label>
<?php				if (isset($errors['first_name']))
					{
						echo $errors['first_name'];
					} ?>
					<input class="form-control" type="text" name="first_name" value="<?= $user['first_name'] ?>" />
					<!-- Last Name -->
					<label class="text-muted" for="last_name">Last Name:</label>
<?php				if (isset($errors['last_name']))
					{
						echo $errors['last_name'];
					} ?>
					<input class="form-control" type="text" name="last_name" value="<?= $user['last_name'] ?>" />
					<!-- Email -->
					<label class="text-muted" for="email">Email:</label>
<?php				if (isset($errors['email']))
					{
						echo $errors['email'];
					} ?>
					<input class="form-control" type="text" name="email" value="<?= $user['email'] ?>" />
					<!-- Description -->
					<label class="text-muted" for="description">Description:</label>
<?php				if (isset($errors['description']))
					{
						echo $errors['description'];
					} ?>
					<textarea class="form-control" name="description" placeholder="A long winded description about my friends and how much I love eating out all the time like that's who I am. I love this a lot."><?= $user['description'] ?></textarea>

					<!-- Submit Form -->
					<input class="form-control btn btn-block blue" type="submit" value="Update Profile" />
				</form>
			</div>
			<div class="profile-box col-sm-12 col-md-4">
				<!-- Registration Date -->
				<label class="text-muted"><?= $user['level'] ?>, registered <?= $user['days'] ?> days ago</label>
				<!-- Update Profile Form -->
				<form class="update-password" action="/users/password/<?= $user['id'] ?>" method="post">
					<!-- Password -->
					<label class="text-muted" for="password">Password:</label>
<?php				if (isset($errors['password']))
					{
						echo $errors['password'];
					} ?>
					<input class="form-control" type="password" name="password" />
					<!-- Password Confirmation -->
					<label class="text-muted" for="password_confirm">Password Confirmation:</label>
<?php				if (isset($errors['password_confirm']))
					{
						echo $errors['password_confirm'];
					} ?>
					<input class="form-control" type="password" name="password_confirm" />

					<!-- Submit Form -->
					<input class="form-control btn btn-block blue" type="submit" value="Update Password" />
				</form>
				<!-- Update Profile Form -->
				<form class="update-privilege" action="/users/level/<?= $user['id'] ?>" method="post">
					<label class="text-muted" for="level">Level:</label>
					<select id="level<?= $user['id'] ?>" class="form-control" name="level">
						<option value="4">User</option>
						<option value="5">Host</option>
						<option value="9">Admin</option>
					</select><br>

					<!-- Submit Form -->
					<input class="form-control btn btn-block blue" type="submit" value="Update Privilege" />
				</form>
			</div>
		</div>
<?php	} ?>
</div>