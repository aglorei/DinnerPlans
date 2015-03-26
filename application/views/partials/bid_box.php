	<!-- Bidding box -->
	<div class="col-xs-12 col-sm-6 col-md-8">
	<h3>Bidding History</h3>
<?php	foreach ($bids as $bid)
		{ ?>
			<div class="row">
				<!-- Meal Title -->
				<div class="col-sm-12 col-md-8">
					<h4><?= $bid['meal'] ?></h4>
				</div>
				<!-- Remaining Time -->
<?php			if (!$bid['ended_at'])
				{ ?>
					<div class="col-sm-12 col-md-4 text-right">
						<h4 class="<?php if($bid['remaining_days']<=1) {echo "text-danger";} else {echo "text-warning";} ?>"><?= $bid['remaining_days'] ?> day<?php if($bid['remaining_days']>1) {echo "s";} ?> left!</h4>
					</div>
<?php			}
				else
				{ ?>
					<div class="col-sm-12 col-md-4">
						<h4 class="text-muted">Bidding has ended!</h4>
					</div>
<?php			} ?>
			</div>
			<!-- Meal Description -->
			<p class="text-muted"><?= $bid['description'] ?></p>

			<div class="bid-box row">
				<!-- Current Price -->
				<div class="col-sm-6 col-md-3">
					<label>Current Price: $<?= $bid['current_price'] ?></label>
				</div>
				<!-- Your Bid -->
				<div class="col-sm-6 col-md-3">
					<label>Your Bid: $<?= $bid['bid'] ?></label>
				</div>
				<!-- Bid Status -->
<?php			if (!$bid['ended_at'])
				{
					if ($this->session->userdata('id') === $bid['highest_bidder'])
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
							<label class="text-success">You are currently the highest bidder!</label>
						</div>
<?php				}
					else
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
							<label class="text-danger">You've been outbid by <?= $bid['highest_bidder_name'] ?>!</label>
						</div>
<?php				} ?>
					<div class="col-sm-12">
						<form class="place-bid" action="/bids/place_bid" method="post">
							<!-- Bid amount -->
							<label for="bid-amount">Place new bid:</label>
							<input type="text" name="bid-amount" >

							<!-- meal_id as hidden input -->
							<input type="hidden" name="meal-id" value="<?= $bid['meal_id'] ?>" />
							<input class="btn blue" type="submit" value="Place bid" />
						</form>
					</div>
<?php			}
				else
				{
					if ($this->session->userdata('id') === $bid['highest_bidder'])
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
							<label class="text-success">You won the meal!</label>
						</div>
<?php				}
					else
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
							<label class="text-danger">You lost to <?= $bid['highest_bidder_name'] ?>!</label>
						</div>
<?php				}
			} ?>
			</div>
<?php	} ?>
	</div>