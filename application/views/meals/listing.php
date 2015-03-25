	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	if(!$meal['bid_count'])
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
	<script src="/assets/js/bootstrap.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/meal-listing.css">
	<script type="text/javascript">

		var lgn = <?php echo json_encode($this->session->userdata('level') ? true : false); ?>;
		var end_time = <?php echo json_encode($meal['end_time']); ?>;
	  var doc = $('endtime');

	  $(document).ready(function() {

	  	countdown();
	  });

	  function countdown()
	  {
	  	var diff = Date.now() - end_time;
	  	var ns = (((3e5-diff) / 1000)>>0);
			var m = (ns/60)>> 0;
			var s = ns - m *60;
			doc.val("Auction Ends: " + m + ":" + ((""+s).length > 1 ? "" : "0") + s + " minutes");

			if(diff > (3e5))
			{
				disable_bid_form();
			}else {
				//setTimeout(countdown(), 1000);
			}
			console.log(diff);
	  }

	  function disable_bid_form()
	  {
	  	var form = document.getElementById('bid-form');
	  	form,disabled = true;
	  }

	  $(document).on('submit', '#bid-form', function() {

	  	if(!lgn)
	  	{
	    	$('#myModal').modal('show');
	  		return false;
	  	}
	  });
	</script>
</head>
<body>
<?php	$this->load->view('./partials/header');?>

	<div class="container">
		<div class="row content">
			<div class="col-xs-7">
				<h3><?=$meal["meal"]?></h3>
				<img src="/assets/img/meals-placeholder.jpg" class="img-rounded">
			</div>
			<div class="col-xs-5">

				<h2><?=$bid_phrase?></h2>

				<form action="/bid" name="bid" method="post" class="form-inline" id='bid-form'>
					<fieldset>
						<legend>Meal Chef: <a href"#" alt="Chef Profile"><?= $meal['chef']?></a></legend>
						<legend>Meal Date: <?= $meal['meal_date'] ?></legend>
						<legend>Current Price: $<?= number_format($meal["current_price"],2,'.','') ?></legend>
						<legend>Current Bid: $<?= $current_bid ?></legend>
						<legend id="endtime"></legend>
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