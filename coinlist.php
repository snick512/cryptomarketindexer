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

<?php include "header.php"; ?>




<?php
$coin = $_GET["add"];


/* adding coin */
if (!$coin) {
//echo "<form action=\"\" method=\"get\">";
//echo "Add coin: <input type=\"text\" name=\"add\">";
//echo "<input type=\"submit\">";
//echo "</form>";

} else {

$mysqli_crawl = DB::queryRaw("UPDATE coinlist SET crawl='1' WHERE slug='$coin'");

echo "Coin <strong><font color=\"purple\">$coin</font></strong> added. ";
echo "<form action=\"\" method=\"get\">";
echo "Add coin: <input type=\"text\" name=\"add\">";
echo "<input type=\"submit\">";
echo "</form>";

}

/* removing coin */
$remove = $_GET["remove"];

if (!$remove) {
// nothing to do here... yet.
} else {

$mysqli_crawl = DB::queryRaw("UPDATE coinlist SET crawl='0' WHERE slug='$remove'");

echo "Coin <strong><font color=\"purple\">$remove</font></strong> removed. <a href=\"?add=$remove\">Undo</a>";

}

// update coin shares
$update = $_GET["stotal"];
$slug = $_GET["slug"];

if (!$update) {
// nothing to do here... yet.
} else {

$mysqli_crawl = DB::queryRaw("UPDATE coinlist SET owned='$update' WHERE slug='$slug'");

echo "<hr />Shares now: <strong><font color=\"purple\">$update</font></strong> for $slug<hr />";

}// end of updating coin shares

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
        // sell @ current rate
        $sell_now = $sellprice_output * $sell;

    $mysqli_owned = DB::queryRaw("SELECT owned from coinlist where slug=%s", $sellslug);
    $owned = $mysqli_owned->fetch_assoc();
    $owned_now = $owned["owned"];
    //$owned = preg_replace('/[^0-9]/', '', $ownednow - $sell);
    $owned_final = $owned_now - $sell;

    $mysqli_cash = DB::queryRaw("SELECT cash from coinlist where slug=%s", $sellslug);
    $cash = $mysqli_cash->fetch_assoc();
    $cash_output = $cash["cash"];
    // sell @ current rate
    $cash_now = $cash_output + $sell_now;

    $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $sellslug);
    $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $sellslug);
    //$mysqli_cash_total = DB::query("UPDATE cash SET cash=%s", $cash_now);

echo "<hr />Sold $sell shares of $sellslug at value $sellprice_output. <br />Current shares: $owned_final <br />Profit: $sell_now <br />Cash: $cash_now<hr />";

    // insert adjustment



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
      // sell @ current rate
      $buy_now = $buyprice_output * $buy;

  $mysqli_owned = DB::queryRaw("SELECT owned from coinlist where slug=%s", $buyslug);
  $owned = $mysqli_owned->fetch_assoc();
  $owned_now = $owned["owned"];
  //$owned = preg_replace('/[^0-9]/', '', $ownednow - $sell);
  $owned_final = $owned_now + $buy;

  $mysqli_cash = DB::queryRaw("SELECT cash from coinlist where slug=%s", $buyslug);
  $cash = $mysqli_cash->fetch_assoc();
  $cash_output = $cash["cash"];
  // sell @ current rate
  $cash_now = $cash_output - $buy_now;

  $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $buyslug);
  $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $buyslug);
  //$mysqli_cash_total = DB::query("UPDATE cash SET cash=%s", $cash_now);

echo "<hr />Bought $buy shares of $buyslug at value $buyprice_output. <br />Current shares: $owned_final <br />Loss: $buy_now <br />Cash: $cash_now<hr />";

  // insert adjustment



} catch(MeekroDBException $e) {
  echo "||Failed||";
}




//
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
