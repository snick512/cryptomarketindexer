<!DOCTYPE html>
<?php
ini_set('display_errors', '0');
if (file_exists("prep.php")) { header("Location: prep.php"); die(); }


require_once "mdie/meekrodb.php";
  //include "refresh.php";

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

        $mysqli_owned = DB::queryRaw("SELECT owned,name from coinlist where slug=%s", $sellslug);
        $owned = $mysqli_owned->fetch_assoc();
        $owned_now = $owned["owned"];
        $name_now = $owned["name"];
        //$owned = preg_replace('/[^0-9]/', '', $ownednow - $sell);
        $owned_final = $owned_now - $sell;

        $mysqli_cash = DB::queryRaw("SELECT cash from coinlist where slug=%s", $sellslug);
        $cash = $mysqli_cash->fetch_assoc();
        $cash_output = $cash["cash"];
        // sell @ current rate
        $cash_now = $cash_output + $sell_now;
        $cash_a_now = $cash_output - $sell_now;

        $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $sellslug);
        $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $sellslug);
      //  $mysqli_profit_update = DB::query("UPDATE coinlist SET profit= profit + %i WHERE slug=%s", $sell_now, $sellslug);
        //$mysqli_cash_total = DB::query("UPDATE cash SET cash=%s", $cash_now);


//echo "<hr />Sold <font color=\"red\">$sell</font> shares of $name_now at value $sellprice_output. <br />Current shares: <font color=\"green\">$owned_final</font> <br />Return: <font color=\"orange\">$sell_now</font> | Gain: -/+ <font color=\"orange\">$cash_a_now</font><br />Cash: <font color=\"white\">$cash_now</font><hr />";
echo "<div class=\"alert alert-dismissible alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">Shares Sold</button>Sold shares of $name_now at value $sellprice_output. <br />Current shares: $owned_final<br />Return: $sell_now | Gain: -/+ $cash_a_now<br />Cash: $cash_now</div>";

    // insert adjustment

  } catch(MeekroDBException $e) {
    echo "<font color=\"red\">||Failed||</font>";
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
  //$mysqli_profit_update = DB::query("UPDATE coinlist SET profit= profit - %i WHERE slug=%s", $buy_now, $buylslug);
  //$mysqli_cash_total = DB::query("UPDATE cash SET cash=%s", $cash_now);

echo "<hr />Bought $buy shares of $buyslug at value $buyprice_output. <br />Current shares: $owned_final <br />Loss: $buy_now <br />Cash: $cash_now<hr />";

  // insert adjustment

} catch(MeekroDBException $e) {
  echo "||Failed||";
}

}?>
<br />
<div id="list"></div>
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

<script>
setInterval(function(){
   $('#output').load('mdie/show.php');
}, 2000)



</script>



</body>
</html>
