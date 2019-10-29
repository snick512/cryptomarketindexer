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
        $sell_now = $sellprice_output * $sell;

        $mysqli_owned = DB::queryRaw("SELECT owned,name,cash from coinlist where slug=%s", $sellslug);
        $owned = $mysqli_owned->fetch_assoc();
        $owned_now = $owned["owned"];
        $name_now = $owned["name"];
        $cash_output = $owned["cash"];
        
        $cash_now = $cash_output + $sell_now;
        $owned_final = $owned_now - $sell;

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
      $buy_now = $buyprice_output * $buy;

      $mysqli_owned = DB::queryRaw("SELECT owned,name,cash from coinlist where slug=%s", $buyslug);
      $owned = $mysqli_owned->fetch_assoc();
      $owned_now = $owned["owned"];
      $owned_name = $owned["name"];
      $cash_output = $owned["cash"];
      $cash_now = $cash_output - $buy_now;
      $owned_final = $owned_now + $buy;


  $mysqli_owned_update = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", $owned_final, $buyslug);
  $mysqli_cash_update = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", $cash_now, $buyslug);
  
?><br /><center>
<div class="card border-success mb-3" style="max-width: 90%;">
  <div class="card-header"><p class="text-info">Purchased at market value <?php echo $buyprice_output; ?></p></div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $owned_name; ?></h4>
    <p class="card-text"><?php echo "$buy_now ($buy shares) of $owned_name purchased."; ?><br /><br />Cash now: $<?php echo number_format($cash_now); ?></p>
  </div>
</div></center>
<?php
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
