	<!-- Bidding box -->
	<div class="col-xs-12 col-sm-6 col-md-8">
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
				{ ?>
<?php				if ($bid['bid'] >= $bid['current_price'])
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
							<label class="text-success">You are currently the highest bidder!</label>
						</div>
<?php				}
					else
					{ ?>
						<div class="col-sm-12 col-md-6 text-right">
						<label class="text-danger">You've been outbid!</label>
					</div>
<?php				} ?>
<?php			}
				else
				{ ?>

<?php			} ?>
			</div>
<?php	} ?>
	</div>