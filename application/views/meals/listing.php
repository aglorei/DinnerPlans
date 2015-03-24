<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>DinnerPlans | Dinner Listings</title>
	<!-- Latest compiled and minified jquery -->
	<script src="/assets/js/jquery-2.1.3.min.js"></script>
	<!-- Latest compiled and minified jquery ui -->
	<script src="/assets/js/jquery-ui.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/meal-listing.css">
</head>
<body>
<?php	$this->load->view('./partials/header'); ?>
	<div class="container">
		<div class="row content">
			<div class="col-xs-7">
				<h3><?=$meal["meal"]?></h3>
				<img src="/assets/img/meals-placeholder.jpg" class="img-rounded lg">
			</div>
			<div class="col-xs-5">
				<h4><?=$bid_phrase?></h4>

				<form action="" name="bid" method="post" class="form-inline">
					<fieldset>
						<legend>Current Bid: $<?=number_format($current_bid["max_bid"],2,'.','')?></legend>
			
						<input type="submit" value="Submit a new bid" class="btn blue">
						<input type="text" placeholder="enter your bid">
					</fieldset>
				</form>
			</div>
		</div>		
		<div class="row">
			<div class="col-xs-12"><?=$meal["description"]?></div>
		</div>	
	</div>
</body>
</html>