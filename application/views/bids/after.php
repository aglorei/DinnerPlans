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
  <script type="text/javascript">

  $(document).ready(function(){

    // if registration fails, display errors in modal window
<?php if (isset($errors))
    { ?>
      $('#myModal').modal('show');
<?php } ?>

    // if login fails, display errors in modal window
<?php if (isset($alert))
    { ?>
      alert('<?= $alert['login'] ?>')
<?php } ?>

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
  <style>
    .super-pad {
      padding-top: 50px;
    }
  </style>
</head>
<body>
  <?php $this->load->view('partials/header'); ?>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <h2><?= $header ?></h2>
        <a href="/meals/listing/<?= $meal['id'] ?>" class='img-rounded'><img src="<?= $meal['img'] ?>" alt="Meal Image" height: 200 width: 200></a>
      </div> <!-- end picture column -->


      <div class="col-md-6 col-sm-12 super-pad">
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
      </div> <!-- end of column -->
    </div> <!-- end of messages row -->
  </div> <!-- end of container ->
</body>
</html>