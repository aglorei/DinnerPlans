<div class="tab-pane fade in active" id="dashboard">
	<div class="row">
		<!-- If user is not a host, apply -->
<?php	if ($this->session->userdata('level') == 'User')
		{ ?>
		<div class="hidden-xs col-sm-3"></div>

		<div class="col-xs-12 col-sm-6">
			<div class="listing-box">
				<form id="host_apply" class="text-center" action="/messages/host_apply" method="post">
					<h4>Want to cook fabulous dinners and give a shot at entertaining? All while meeting interesting new people and making some money to boot? Try your hand at hosting! One of our admins will receive your application for review, and we'll get back to you in a few days!</h4>

					<!-- Submit Form -->
					<input class="btn blue" type="submit" value="Apply Now!" />
				</form>
			</div>
		</div>

		<div class="hidden-xs col-sm-3"></div>

		<!-- Else, bring up 'listings' and 'create' tabs -->
<?php	}
		else
		{ ?>
		<div class="col-xs-12 col-sm-3">
			<!-- Tab Selectors -->
			<ul class="nav nav-stacked nav-tabs" role="tablist">
				<li id="listings-tab" role="presentation"><a href="#listings" data-toggle="tab">Listings</a></li>
				<li id="plan-tab" role="presentation"><a href="#plan" data-toggle="tab">Plan an Event!</a></li>
			</ul>
		</div>

		<div class="col-xs-12 col-sm-9">
			<!-- Tab Contents -->
			<div class="tab-content">
				<!-- Listings -->
				<div class="tab-pane fade in" id="listings">
<?php				foreach ($meals as $meal)
					{ ?>
						<div class="listing-box">
							<!-- Row 1 -->
							<div class="row">
								<!-- Meal Name -->
								<div class="col-xs-12 col-sm-9">
									<h4><?= $meal['meal'] ?> on <?= $meal['meal_date'] ?></h4>
								</div>
								<!-- Meal Category -->
								<div class="col-xs-12 col-sm-3 text-right">
									<h4 class="text-muted"><?= $meal['category'] ?></h4>
								</div>
							</div>
							<!-- Row 2 -->
							<p class="text-muted"><?= $meal['description'] ?></p>
							<!-- Row 3 -->
							<div class="row">
<?php							if (!$meal['ended_at'])
								{ ?>
									<!-- Current Price -->
									<div class="col-xs-6 col-sm-3">
										<p>Current Price: $<?= $meal['current_price'] ?></p>
									</div>
									<!-- Bidding information -->
									<div class="col-xs-6 col-sm-9 text-right text-success">
										<p>Bidding began <?= $meal['created_at'] ?>, ends in <?= $meal['remaining_days'] ?> day<?php if($meal['remaining_days']>1) {echo "s";} ?>.</p>
									</div>
<?php							}
								else
								{ ?>
									<!-- Final Price -->
									<div class="col-xs-6 col-sm-3">
										<p>Final Price: $<?= $meal['current_price'] ?></p>
									</div>
									<!-- Bidding information -->
									<div class="col-xs-6 col-sm-9 text-right text-danger">
										<p>Bidding began <?= $meal['created_at'] ?>, ended on <?= $meal['ended_at'] ?>.</p>
									</div>
<?php							} ?>
							</div>
						</div>
<?php				} ?>
				</div>
				<!-- Plan an Event! -->
				<div class="tab-pane fade in" id="plan">
					<div class="listing-box">
<?php					$this->load->view('partials/listing_form') ?>
					</div>
				</div>
			</div>
		</div>
<?php	} ?>
	</div>
</div>