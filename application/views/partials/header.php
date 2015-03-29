<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="row header">
			<div class="col-xs-6 col-md-2">
				<a href="/"><h2>DinnerPlans</h2></a>
			</div>
				<!-- if logged in, else register -->
<?php			if ($this->session->userdata('level'))
				{ ?>
					<!-- Regular login viewable on >=.md viewports -->
					<div class="hidden-xs hidden-sm col-md-10">
						<form class="navbar-form navbar-right" action="/users/logout" method="post">
							<a class="btn" href="/account" role="button">My Account</a>
							<label>Welcome <?= $this->session->userdata('first_name') ?>!</label>
							<input class="blue btn" type="submit" value="Logout" />
						</form>
					</div>
					<!-- Dropdown login viewable on <.md viewports -->
					<div class="visible-xs visible-sm col-xs-6 btn-group">
						<button type="button" class="btn blue dropdown-toggle pull-right" data-toggle="dropdown" aria-expanded="false">Welcome <?= $this->session->userdata('first_name') ?>! <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<form class="navbar-form navbar-right" action="/users/logout" method="post">
								<li>
									<a class="btn" href="/account" role="button">My Account</a>
									<input class="blue btn" type="submit" value="Logout" />
								</li>
							</form>
						</ul>
					</div>
					<?php			}
				else
				{ ?>
					<!-- Regular login viewable on >=.md viewports -->
					<div class="hidden-xs hidden-sm col-md-10">
						<form class="navbar-form navbar-right" action="/users/login" method="post">
							<a class="btn" href="#" role="button" data-toggle="modal" data-target="#myModal">Don't have an account? Register!</a>

							<label for="email">Email:</label>
							<input type="email" name="email" />

							<label for="password">Password:</label>
							<input type="password" name="password" />

							<input class="btn blue" type="submit" value="Login" />
						</form>
					</div>
					<!-- Dropdown login viewable on <.md viewports -->
					<div class="visible-xs visible-sm col-xs-6 btn-group">
						<button type="button" class="btn blue dropdown-toggle pull-right" data-toggle="dropdown" aria-expanded="false">Login <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<form class="navbar-form navbar-right" action="/users/login" method="post">
								<li><label for="email">Email:</label></li>
								<li><input class="form-control" type="email" name="email" /></li>
								<li><label for="password">Password:</label></li>
								<li><input class="form-control" type="password" name="password" /></li>
								<li><input class="btn blue" type="submit" value="Login" /></li>
								<li class="divider"></li>
								<li><a class="btn" href="#" role="button" data-toggle="modal" data-target="#myModal">Don't have an account? Register!</a></li>
							</form>
						</ul>
					</div>
<?php			} ?>
		</div>
	</div>
</nav>

<nav class="navbar navbar-default">
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="navbar-collapse">
		<ul class="nav navbar-nav">
			<li><a href="/meals/listings">Browse</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Categories <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="/meals/listings/2">American</a></li>
					<li><a href="/meals/listings/7">Comfort Food</a></li>
					<li><a href="/meals/listings/3">French</a></li>
					<li><a href="/meals/listings/5">Indian</a></li>
					<li><a href="/meals/listings/8">Italian</a></li>
					<li><a href="/meals/listings/1">North African</a></li>
					<li><a href="/meals/listings/4">Tapas</a></li>
				</ul>
			</li>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Not yet registered? Create an account with us!</h4>
			</div>
			<!-- Modal Body -->
			<div class="modal-body">
				<div class="container-fluid">
					<form id="users-register" action="/users/register" method="post">
						<!-- First Name -->
						<label for="first_name">First Name:</label><br>
<?php					if (isset($errors['first_name']))
						{
							echo $errors['first_name'];
						} ?>
						<input class="form-control" type="text" name="first_name" value="<?php if (isset($errors_input['first_name'])) { echo $errors_input['first_name']; } ?>" />
						<!-- Last Name -->
						<label for="last_name">Last Name:</label><br>
<?php					if (isset($errors['last_name']))
						{
							echo $errors['last_name'];
						} ?>
						<input class="form-control" type="text" name="last_name" value="<?php if (isset($errors_input['last_name'])) { echo $errors_input['last_name']; } ?>" />
						<!-- Email -->
						<label for="email">Email:</label><br>
<?php					if (isset($errors['email']))
						{
							echo $errors['email'];
						} ?>
						<input class="form-control" type="email" name="email" value="<?php if (isset($errors_input['email'])) { echo $errors_input['email']; } ?>" />
						<!-- Password -->
						<label for="password">Password:</label><br>
<?php					if (isset($errors['password']))
						{
							echo $errors['password'];
						} ?>
						<input class="form-control" type="password" name="password" />
						<!-- Password Confirmation -->
						<label for="password_confirm">Confirm Password:</label><br>
<?php					if (isset($errors['password_confirm']))
						{
							echo $errors['password_confirm'];
						} ?>
						<input class="form-control" type="password" name="password_confirm" />
						<!-- Submit Form -->
						<input class="btn blue" type="submit" value="Register" />

						<button type="btn" class="btn btn-default" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			var value = 1000;
var counter = 0;
			function check_database(value)
			{
				console.log("the value is : " + value);
				$.get(
						"/db_check",
						function(data) 
						{
							console.log("the returned data is : " + data);
							// convert to milliseconds
							value = data * 1000;
							if(counter > 10)
		        		clearInterval(inte);

		        	counter++;
		        	return value;
						},
						'json'
					);
				return false;
			}
			var inte = setInterval(check_database(value), 1000);
		});
	</script>
</div>