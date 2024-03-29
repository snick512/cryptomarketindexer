<!DOCTYPE html>
<?php
include "mdie/meekrodb.php";
ini_set('display_errors', '0');
$go = $_GET["c"];
?>
<html>
<head>
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="-1">
 <script src="jquery.min.js"></script>
 <link rel="stylesheet" href="bootstrap/bootstrap.min.css" media="screen">


</head>

<body>
<?php

include "header.php";

// queries for individual coin information, switches...

DB::$error_handler = "false";
DB::$throw_exception_on_error = "true";

try {
  $mysqli_result = DB::queryRaw("SELECT * FROM coinlist WHERE slug=%s", $go);
  $showdata = $mysqli_result->fetch_assoc();
  $f_name = $showdata['name'];
  $pass = $showdata['slug'];
  $crawl = $showdata['crawl'];
  $cash = $showdata['cash'];
  $exchange = $showdata['exchange'];
  $image = $showdata["infoimage"];

  $mysqli_exchange = DB::queryRaw("SELECT * FROM exchanges WHERE exchange=%s", $exchange);
  $mysqli_exchange_a = $mysqli_exchange->fetch_assoc();
  $exchangename = $mysqli_exchange_a['exchangename'];

} catch (MeekroDBException $e) {
  // code.
}

?>
<br />


<center>
<div class="card border-warning mb-3" style="max-width: 90%;">
<h3 class="card-header"><?php echo "$f_name"; ?></h3>
<div class="card-body">
  <h5 class="card-title"></h5>
  <h6 class="card-subtitle text-muted">$<?php echo number_format($cash); ?></h6>
</div>
 
<img src="mdie/images/coins/<?php echo "$image"; ?>" width="100px"> <br />

 
<script src="https://widgets.coingecko.com/coingecko-coin-price-chart-widget.js"></script>

<p align="center"><coingecko-coin-price-chart-widget  coin-id="<?php echo "$pass";?>" currency="usd" height="300" width="50%" locale="en"></coingecko-coin-price-chart-widget></p>

<div class="card-body">
  <p class="card-text"></p>
</div>

<div class="card-body">
  <?php
  if ($crawl == 1) {
    echo "<a href=\"mdie/status.php?s=0&c=$pass\"><button type=\"button\" class=\"btn btn-outline-warning\">Disable</button></a> ";
  } else {
    echo "<a href=\"mdie/status.php?s=1&c=$pass\"><button type=\"button\" class=\"btn btn-outline-success\">Enable</button></a> ";
  }

?>
</div>
<div class="card-footer text-muted">
<p class="text-info">Currently pulling data from <?php echo "$exchangename"; ?></p>
</div>
</div>
</center>







<br />
    <div align="center" id="output">
      <div
      class="progress-bar progress-bar-striped progress-bar-animated"
      role="progressbar"
      aria-valuenow="95"
      aria-valuemin="0"
      aria-valuemax="100"
      style="width: 75%">
    Loading ... Please allow a few minutes to populate after any changes.</div>
    </div>

    <hr />

<script>
setInterval(function(){
   $('#output').load('mdie/detail.php?c=<?php echo "$pass"; ?>');
}, 2000)
</script>

</body>
</html>
