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
	<script type="text/javascript">

		var lgn = <?php echo json_encode($this->session->userdata('level') ? true : false); ?>;
		var end_time = <?php echo json_encode($meal['end_time']); ?>;


	  $(document).ready(function() {
	  	function timer() {
		  	var now = Math.floor(Date.now() / 1000);
		  	var seconds = end_time - now;
		    var days        = Math.floor(seconds/24/60/60);
		    var hoursLeft   = Math.floor((seconds) - (days*86400));
		    var hours       = Math.floor(hoursLeft/3600);
		    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
		    var minutes     = Math.floor(minutesLeft/60);
		    var remainingSeconds = seconds % 60;

		    if(minutes < 10) {
		    	minutes = "0" + minutes;
		    }
		    if(hours < 10) {
		    	hours = "0" + hours;
		    }
		    if(days < 10) {
		    	day = "0" + days;
		    }
		    if (remainingSeconds < 10) {
		        remainingSeconds = "0" + remainingSeconds; 
		    }
		    $('#endtime').html(days + ":" + hours +":" + minutes +":" + remainingSeconds);
		    if (seconds <= 0) {
		    		$('#endtime').html("COMPLETED");
		        clearInterval(countdownTimer);
		        disable_bidding();
		    } else {
		        seconds--;
		    }
			}

	  	var countdownTimer = setInterval(timer, 1000);
	  });

	  function disable_bidding()
	  {

			$('#bid-button').prop('disabled', true);
			$('#bid-box').prop('disabled', true);
			$('#bid-box').attr('placeholder', "Bidding complete");
	  }

	  $(document).on('submit', '#bid-form', function() {

	  	if(!lgn)
	  	{
	    	$('#myModal').modal('show');
	  		return false;
	  	}
	  });
	</script>

	<style>
			td + td {
				border-left: 1px solid gray;
			}
			tbody:last-child {
				border: 0;
			}
			.img-container {
				height: 400px;
			}
	</style>
</head>
<body>
<?php	$this->load->view('./partials/header');?>

	<div class="container">
		<div class="row content">
			<div class="col-xs-12 col-lg-7">
				<div>
					<img src="<?= $meal['img'] ?>" class="img-rounded img-container" alt='Meal Image'>
				</div> <!-- end of image container -->
			</div> <!-- end of image column -->
			<div class="col-xs-12 col-lg-5">

				<h2><?=$bid_phrase?></h2>

					<fieldset>
						<table class="table">
							<tbody>
								<tr>
									<td>Meal Chef</td>
									<td><a href"#" alt="Chef Profile"><?= $meal['host']?></a></td>
								</tr>
								<tr>
									<td>Meal Date</td>
									<td><?= $meal['meal_date'] ?></td>
								</tr>
								<tr>
									<td>Current Price</td>
									<td>$<?= number_format($meal["current_price"],2,'.','') ?></td>
								</tr>
<?php
									if($meal['bid_count'])
									{
?>
									<tr>
										<td>Highest Bidder</td>
										<td><a href="#"><?= $highest_bidder['user_name'] ?></a></td>
									</tr>
<?php
									}
?>
								<tr>
									<td>Current Bid</td>
									<td>$<?= $current_bid ?></td>
								</tr>
								<tr>
									<td>Auction End</td>
									<td id="endtime"></td>
								</tr>
								<tr>
									<form action="/bid" name="bid" method="post" class="form-inline" id='bid-form'>
										<div class="form-group">
											<td><input type="submit" value="Submit a new bid" class="btn blue" id="bid-button"></td>
											<td>
												<input type="text" name="bid-amount" placeholder="enter your bid" id="bid-box" required>
												<input type="hidden" name="meal-id" value="<?= $meal['id']?>">
											</td>
										</div>
									</form>
								</tr>
							</tbody>
						</table> <!-- end of info table -->
					</fieldset>
			</div>
			<div class="bid col-xs-5">
				<h3>About Your Host: <?=$meal["host"]?></h3>
				<p><?=$meal["bio"]?></p>
			</div> <!-- end of bio column -->
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