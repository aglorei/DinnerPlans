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

		// uncheck all checkboxes to remove filter preferences
        $('#uncheckAll').on('click',function(){

			$('.chkbox').each(function(){
				this.checked = false;
			});

		});

	});

	</script>
	<!-- Latest compiled and minified Bootstrap css -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<!-- Stylesheet for header partial -->
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	<!-- Stylesheet for this view -->
	<link rel="stylesheet" type="text/css" href="/assets/css/meal-listings.css">
</head>
<body>
<?php	$this->load->view('partials/header'); ?>
	<div class="container">

		<div class="row content">
			<div class="col-xs-2">
				<form action="/meals/filter/" name="preferences" class="preferences" method="get">
					<fieldset>
						<legend>Refine Your Listings</legend>
						<div class="control-group">
							<p>Dietary Preferences</p>
<?php
						foreach ($options as $option) 
						{
							// construct name of checkbox field
							$checkbox = 'dietary_' . $option['id'];	
?>	
							<label>
								<input name="dietary_<?=$option["id"]?>" type="checkbox" class="chkbox" value="<?=$option["id"]?>"
<?php 
								// if checkbox exists in post, add checked property
								if($this->input->get($checkbox))
								{
									echo "checked";
								}
?>
								> <?=$option["option"]?>
							</label>						
<?php
						}
?>
						</div>	
						<div class="control-group">
							<p>Price:</p>						
							<label>
								<input name="price_1" type="checkbox" class="chkbox" value="1"
<?php 
								if($this->input->get("price_1"))
								{
									echo "checked";
								}
?>
								> $ ($0-50)
							</label>
							<label>
								<input name="price_2" type="checkbox" class="chkbox" value="2"
<?php 
								if($this->input->get("price_2"))
								{
									echo "checked";
								}
?>
								> $$ ($50-100) 
							</label>
							<label>
								<input name="price_3" type="checkbox" class="chkbox" value="3"
<?php 
								if($this->input->get("price_3"))
								{
									echo "checked";
								}
?>
								> $$$ ($100-150)
							</label>
							<label>
								<input name="price_4" type="checkbox" class="chkbox" value="4"
<?php 
								if($this->input->get("price_4"))
								{
									echo "checked";
								}
?>
								> $$$$ ($150-200)
							</label>
						</div>
						<div class="control-group">
							<p>Ratings:</p>						
							<label>
								<input name="rating_1" type="checkbox" class="chkbox" value="1"
								<?php 
									if($this->input->get("rating_1"))
									{
										echo "checked";
									}
	?>
								> 1 star +
							</label>						
							<label>
								<input name="rating_2" type="checkbox" class="chkbox" value="2"
<?php 
								if($this->input->get("rating_2"))
								{
									echo "checked";
								}
?>
								> 2 star +
							</label>						
							<label>
								<input name="rating_3" type="checkbox" class="chkbox" value="3"
<?php 
								if($this->input->get("rating_3"))
								{
									echo "checked";
								}
?>
								> 3 star +
							</label>						
							<label>
								<input name="rating_4" type="checkbox" class="chkbox" value="4"
<?php 
								if($this->input->get("rating_4"))
								{
									echo "checked";
								}
?>
								> 4 star +
							</label>
						</div>	
						<label>
							<a href="/meals/listings/" id="uncheckAll">Remove all preferences</a>
						</label>						
						<input type="submit" value="search" class="btn blue">
					</fieldset>
				</form>
			</div><!-- end search form -->


			<div class="col-xs-10">
				<div class="row">
<?php
			if(!$meals)
			{
				echo "No meals currently match all of your preferences. Please try widening your search.";
			}

			foreach ($meals as $meal) 
			{
				// get image for current meal
				$meal['img'] = $this->Meal->get_meal_img($meal['id'])['img_path'];

				// get dietary options for current meal
				$meal['options'] = $this->Meal->show_options_by_meal($meal['id']);

				$meal["description"] = character_limiter($meal["description"],115,'&#8230;');
?>
					<div class="col-xs-4 meal-box">
						<a href="/meals/listing/<?=$meal["id"]?>"><img src="<?=$meal["img"]?>" class="img-rounded sm"></a>
						<h5><strong><?=$meal["meal"]?></strong></h5>

						<p class="description"><?=$meal["description"]?></p>
<?php 
					// only display this text if options are available
					if(count($meal['options']))
					{
?>
						<p><em>(Options available: <?=$meal["options"]?>)</em></p>
<?php											
					}
?>
						<div class="row">
							<div class="col-xs-6">
								<p class="date">March 31, 2015</p>
							</div>
							<div class="col-xs-6">
								<p class="price text-right">$<?=number_format($meal["current_price"],2,'.','')?></p>
							</div>
						</div>												
						<p class="rating text-center">4 stars</p>
					</div>
<?php
				}
?>
				</div><!-- end row -->
			</div><!-- end listings -->
		</div><!-- end row -->
	</div><!-- end container -->
</body>
</html>