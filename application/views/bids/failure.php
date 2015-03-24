<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>DinnerPlans: Bid Failed</title>
  <!-- Latest compiled and minified jquery -->
  <script src="/assets/js/jquery-2.1.3.min.js"></script>
  <!-- Latest compiled and minified jquery ui -->
  <script src="/assets//js/jquery-ui.min.js"></script>
  <!-- Latest compiled and minified CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>
<body>
<?php $this->load->view('partials/header'); ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-12">
        <h3>Bat Failed</h3>
        <a href="/meals/listing/<?= $meal['id'] ?>"><img src="<?= $meal['img'] ?>" alt="meal image"></a>

      </div>
      <div class="col-lg-6 col-sm-12">
        
      </div>
    </div>
  </div>
</body>
</html>