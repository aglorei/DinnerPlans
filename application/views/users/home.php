<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>DinnerPlans</title>
	<!-- Latest compiled and minified jquery -->
	<script src="/assets/js/jquery-2.1.3.min.js"></script>
	<!-- Latest compiled and minified jquery ui -->
	<script src="/assets/js/jquery-ui.min.js"></script>
	<!-- Latest compiled and minified Bootstrap js -->
	<script src="/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">

	$(document).ready(function(){

		// if registration fails, display errors in modal window
<?php	if (isset($errors))
		{ ?>
			$('#myModal').modal('show');
<?php	} ?>

		// if login fails, display errors in modal window
<?php	if (isset($alert))
		{ ?>
			alert('<?= $alert['login'] ?>');
<?php	} ?>

		// keep dropdown login open when focusing on form input
		$(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });

	});

	</script>
	<!-- Latest compiled and minified Bootstrap css -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<!-- Stylesheet for header partial -->
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>
<body>
<?php	$this->load->view('partials/header'); ?>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<!-- Slide 1 -->
			<div class="item active">
				<img src="/assets/images/home1.jpg" alt="home1">
				<div class="carousel-caption">
					<h1>Bon Appétit!</h1>
					<p class="lead">We're dedicated to bringing people together at the dinner table. Get started by browsing listings of events made by both restaurant professionals and cooking enthusiasts like yourself. Whether it's chef-driven menus or casual dinner parties with new friends, take a look at our hosts' listings and bid for a seat at their table.</p>
					<p><a class="btn btn-lg btn-primary blue" href="/meals/listings">Take a look!</a></p>
				</div>
			</div>

			<!-- Slide 2 -->
			<div class="item">
				<img src="/assets/images/home2.jpg" alt="home2">
				<div class="carousel-caption">
					<h1>We Would Love to Be Your Guests</h1>
					<p class="lead">Do you think that you have what it takes to cook full course dinners and indulge guests with entertainment and mood setting? Apply to be one of our acclaimed hosts! You'll be able to meet interesting people, excercise your passion, and make some money to boot!</p>
					<p><a class="btn btn-lg btn-primary blue" href="/messages/host_apply">Apply now!</a></p>
				</div>
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<!-- Description containers -->
	<div class="container">
		<div class="row">
			<div class="col-s-12 col-md-4">
				<h2>Select your dietary preferences. <span class="text-muted">Gluten-free dining? No problem.</span></h2>
				<p class="lead">Our hosts care about what they put on their own dining table just like you. When it comes to covering food allergies, we make sure to keep your health and well-being a top priority. And whether you characterize your diet as vegetarian, vegan, paleo, or raw, we've got you covered here.</p>
			</div>

			<div class="col-s-12 col-md-4">
				<h2>Craving authentic Indian? How about some traditional French cuisine? <span class="text-muted">Be our guests.</span></h2>
				<p class="lead">Our handpicked hosts are verified within their field to strict standards. And the results speak for themselves. If you've always thought that no one makes pizza from scratch like your grandma who grew up in Italy, let us introduce you to the grandma who grew up in Italy.</p>
			</div>

			<div class="col-s-12 col-md-4">
				<h2>Need plans for a Friday night dinner party? <span class="text-muted">We've got you covered.</span></h2>
				<p class="lead">Bid on seats for events from popular chefs in your city. Our top-rated hosts will wine and dine you in a variety of settings, whether it's an casual apartment get-together with intimate friends or a luxe balcony cocktail party to paint the town red. Pick the food and the mood, and we'll take care of the rest.</p>
			</div>
		</div>
	</div>
</body>
</html>