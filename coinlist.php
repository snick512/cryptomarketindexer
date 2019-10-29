<!DOCTYPE html>
<?php

require_once "mdie/meekrodb.php";
ini_set('display_errors', '0');
?>
<html>
<head>
  <script src="jquery.min.js"></script>
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css" media="screen">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="-1">
</head>

<body>

<?php 

include "header.php"; 


// update coin shares
$update = $_GET["stotal"];
$slug = $_GET["slug"];
/*

removed for now 


if (!$update) {
// nothing to do here... yet.
} else {

$mysqli_crawl = DB::queryRaw("UPDATE coinlist SET owned='$update' WHERE slug='$slug'");

echo "<hr />Shares now: <strong><font color=\"purple\">$update</font></strong> for $slug<hr />";

}// end of updating coin shares

*/

$sell = $_GET["sell"];
$sellslug = $_GET["sellslug"];

    if (!$sell) {
      // ...

    } else {

DB::$throw_exception_on_error = "true";
  try {

    $dbcoin = str_ireplace("-", "_", $sellslug);

        $mysqli_price = DB::queryRaw("SELECT priceusd from exchange_$dbcoin order by id desc limit 1");
        $sellprice = $mysqli_price->fetch_assoc();
        $sellprice_output = $sellprice["priceusd"];
        $sell_now = $sellprice_output * $sell;

    $mysqli_owned = DB::queryRaw("SELECT owned,cash from coinlist where slug=%s", $sellslug);
    $owned = $mysqli_owned->fetch_assoc();
    $cash_output = $cash["cash"];
    $owned_now = $owned["owned"];
    $owned_final = $owned_now - $sell;
    $cash_now = $cash_output + $sell_now;

    $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $sellslug);
    $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $sellslug);
    
?>
<br /><center>
<div class="card border-success mb-3" style="max-width: 90%;">
  <div class="card-header"><p class="text-info">Sold at market value <?php echo $sellprice_output; ?></p></div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $name_now; ?></h4>
    <p class="card-text"><?php echo "$sell_now ($sell shares) of $name_now purchased."; ?><br /><br />Cash now: $<?php echo number_format($cash_now); ?></p>
  </div>
</div></center>
<?php

  } catch(MeekroDBException $e) {
    echo "||Failed||";
  }
}


// buy

$buy = $_GET["buy"];
$buyslug = $_GET["buyslug"];
if (!$buy) {
  // ...

} else {
try {

  $dbcoin = str_ireplace("-", "_", $buyslug);

      $mysqli_price = DB::queryRaw("SELECT priceusd from exchange_$dbcoin order by id desc limit 1");
      $buyprice = $mysqli_price->fetch_assoc();
      $buyprice_output = $buyprice["priceusd"];
      $buy_now = $buyprice_output * $buy;

  $mysqli_owned = DB::queryRaw("SELECT owned,cash from coinlist where slug=%s", $buyslug);
  $owned = $mysqli_owned->fetch_assoc();
  $owned_now = $owned["owned"];
  $cash_output = $cash["cash"];
  $cash_now = $cash_output - $buy_now;
  $owned_final = $owned_now + $buy;

  $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $buyslug);
  $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $buyslug);
  
?>
<br /><center>
<div class="card border-success mb-3" style="max-width: 90%;">
  <div class="card-header"><p class="text-info">Purchased at market value <?php echo $buyprice_output; ?></p></div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $owned_name; ?></h4>
    <p class="card-text"><?php echo "$buy_now ($buy shares) of $owned_name purchased."; ?><br /><br />Cash now: $<?php echo number_format($cash_now); ?></p>
  </div>
</div></center>
<?php 

} catch(MeekroDBException $e) {
  echo "||Failed||";
}

    }


?>



<!--  <div id="coinlist">Loading ...</div>

<script>
setInterval(function(){
   $('#coinlist').load('mdie/coinshow.php');
}, 3600)
</script>-->
<?php include "mdie/coinshow.php"; ?>

</body>
</html>
