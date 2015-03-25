<?php
defined('BASEPATH') OR exit('No direct script access allowed');
var_dump($meal);
	if($meal['initial_price'] == $meal['current_price'])
	{
		$current_bid = number_format($meal["initial_price"],2,'.','');
	}else 
	{
		$current_bid = number_format($meal["current_price"] + 5,2,'.','');
	}

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
	<script>
	  $(document).ready(function() {
	    
	  });



	</script>

</head>
<body>
<?php	$this->load->view('./partials/header');?>

	<div class="container">
		<div class="row content">
			<div class="col-xs-7">
				<h3><?=$meal["meal"]?></h3>
				<img src="/assets/img/meals-placeholder.jpg" class="img-rounded lg">
			</div>
			<div class="col-xs-5">

				<h4><?=$bid_phrase?></h4>

				<form action="/bid" name="bid" method="post" class="form-inline">
					<fieldset>
						<legend>Current Bid: $<?= $current_bid ?></legend>
						<div class="form-group">
							<input type="submit" value="Submit a new bid" class="btn blue">
							<input type="text" name="bid-amount" placeholder="enter your bid" required>
							<input type="hidden" name="meal-id" value="<?= $meal['id']?>">
						</div>
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