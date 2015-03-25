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
			alert('<?= $alert['login'] ?>')
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
	<!-- Stylesheet for this view -->
	<link rel="stylesheet" type="text/css" href="/assets/css/meal-listing.css">
</head>
<body>
<?php	$this->load->view('partials/header'); ?>
	<div class="container">
		<div class="row content">
			<div class="col-xs-7">
				<img src="<?=$meal_img?>" class="img-rounded lg">
			</div>			
			<div class="bid col-xs-5">
				<form action="" name="bid" method="post" class="bid form-inline">
					<fieldset>
						<legend>Current Bid: $<?=number_format($current_bid,2,'.','')?></legend>			
						<input type="submit" value="Submit New Bid" class="btn blue">
						<input type="text" placeholder="enter your bid here">
						 <p><span class="help-block"><em>Disclaimer:</em> Use this service at your own risk. Meals are cooked to order by a personal chef and may be served raw or undercooked. Consuming raw or undercooked meats, poultry, seafood, shellfish, or eggs may increase your risk of food-borne illness.</span></p>
					</fieldset>
				</form>
			</div>
			<div class="bid col-xs-5">
				<h3>About Your Host: <?=$meal["host"]?></h4>
				<p><?=$meal["bio"]?></p>
			</div>
		</div>
		<div class="row">
			<div class="meal col-xs-12">			
				<h2><?=$meal["meal"]?></h2>
<?php 		// output dietary options, if available
			if (strlen($meal["options"]))
			{
?>
				<p>(Options available: <?=$meal["options"]?>)</p>
<?php 
			}
?>
				<p><?=$meal["description"]?></p>
			</div>
		</div>		
	</div>
</body>
</html>