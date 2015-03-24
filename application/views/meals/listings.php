<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
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
	<link rel="stylesheet" type="text/css" href="/assets/css/meal-listings.css">
</head>
<body>
<?php	$this->load->view('./partials/header'); ?>
	<div class="container">

		<div class="row content">
			<div class="col-xs-12 categories">
<?php
			foreach ($categories as $category) 
			{
?>
				<a href="/meals/listings/<?=$category["id"]?>"><?=$category["category"]?></a>
<?php
			}
?>
			</div>
			<div class="col-xs-3">
				<form action="/meals/filter/" name="preferences" class="preferences" method="post">
					<fieldset>
						<legend>Refine Your Listings</legend>
						<div class="control-group">
							<p>Dietary Preferences</p>
							<label><input name="dietary_1" type="checkbox" value="1"> Vegetarian</label>						
							<label><input name="dietary_2" type="checkbox" value="2"> Gluten-free</label>		
							<label><input name="dietary_3" type="checkbox" value="3"> Paleo</label>		
						</div>			

						<div class="control-group">
							<p>Price:</p>						
							<label><input name="price_1" type="checkbox" value="1"> $</label>
							<label><input name="price_2" type="checkbox" value="2"> $$</label>
							<label><input name="price_3" type="checkbox" value="3"> $$$</label>
							<label><input name="price_4" type="checkbox" value="4"> $$$$</label>
						</div>

						<div class="control-group">
							<p>Ratings:</p>						
							<label><input name="star_1" type="checkbox" value="1"> 1 star +</label>						
							<label><input name="star_2" type="checkbox" value="2"> 2 star +</label>						
							<label><input name="star_3" type="checkbox" value="3"> 3 star +</label>						
							<label><input name="star_4" type="checkbox" value="4"> 4 star +</label>
						</div>							
						<input type="submit" value="search" class="button blue">
					</fieldset>
				</form>
			</div><!-- end search form -->


			<div class="col-xs-9">
<?php
			foreach ($meals as $meal) 
			{
?>
				<div class="row">
					<div class="col-xs-4 listing-box">
						<a href="/meals/listing/<?=$meal["id"]?>"><img src="/assets/img/meals-placeholder.jpg" class="img-rounded sm"></a>
						<h5><strong><?=$meal["meal"]?></strong></h5>

						<p><?=$meal["description"]?></p>

						<div class="row">
							<div class="col-xs-6">
								<p class="date">March 31, 2015</p>
							</div>
							<div class="col-xs-6">
								<p class="price text-right">$<?=number_format($meal["initial_price"],2,'.','')?></p>
							</div>
						</div>
												
						<p class="rating text-center">4 stars</p>
					</div>
				</div>
<?php
			}
?>
			</div><!-- end listings -->
		</div><!-- end row -->
	</div><!-- end container -->
</body>
</html>