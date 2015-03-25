<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  if(!$this->session->userdata('level'))
  {
    redirect("/");
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DinnerPlans: Bid Complete</title>
  <!-- Latest compiled and minified jquery -->
  <script src="/assets/js/jquery-2.1.3.min.js"></script>
  <!-- Latest compiled and minified jquery ui -->
  <script src="/assets/js/jquery-ui.min.js"></script>
  <!-- Latest compiled and minified Bootstrap js -->
  <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2><?= $header ?></h2>
        <a href="/meals/listing/<?= $meal['id'] ?>"><img src="<?= $meal['img'] ?>" alt="Meal Image"></a>
        <p>
          <?= $bid_message ?>
        </p>
<?php
            if(isset($winner))
            {
              if($winner)
              {
?>
                <p>Congratulations! You are the highest bidder for <?= $meal['meal'] ?>.
<?php
                    if(time() - $meal['end_time'] > 0)
                    {
?>
                      You can still be outbid. Click <a href="/meals/listing/<?= $meal['id'] ?>">here</a> to increase your bid amount.
<?php
                    }
?>
                </p>
<?php
              } else {
?>
                <p>Your bid amount was not sufficient to take the lead!</p>
<?php
                if(time() - $meal['end_time'] > 0)
                {
?>
                <p>There's still time left! Increase your bid amount <a href="/meals/listing/<?= $meal['id'] ?>">now!</a></p>
<?php
                }
              }
            }
           ?>
      </div>
    </div>
  </div>
</body>
</html>