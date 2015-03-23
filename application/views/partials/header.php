<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="row header">
			<div class="col-xs-3">
				<a href="/"><h2>Dinner Plans</h2></a>
			</div>

			<div class="col-xs-9 text-right">
<?php			if ($this->session->userdata('level'))
				{ ?>
					<form action="/logout" method="post">
						<label>Welcome <?= $this->session->userdata('first_name') ?>!</label>
						<input class="blue button" type="submit" value="Logout" />
					</form>
<?php			}
				else
				{ ?>
					<form action="/users/verify" method="post">
						<a href="/login">Don't have an account with us? Register!</a>

						<label for="email">Email:</label>
						<input type="email" name="email" />

						<label for="password">Password:</label>
						<input type="password" name="password" />

						<input class="button blue" type="submit" value="Login" />
					</form>
<?php			} ?>
			</div>
		</div>
	</div>
</nav>