<?php
include "meekrodb.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');

/*
Recycled from updatecol.php - Sat Oct 12, 2019

Set Simulation - October 22, 01:25.

Set all crawl=1 to owned=1 and crash=last-index



*/

$c = $_GET["coin"];
$dbcoin = str_ireplace("-", "_", $c); // replace -s with _s.
$tb = "exchange_$dbcoin";

//DB::$success_handler = "update_success";

// update error
DB::$error_handler = "update_error";
function update_error($params) {
$err3_output = array("ERROR" => array(
  "SQL" => array(
    "Error" => $params['error'],
    "Query" => $params['query']
  )
));

echo json_encode($err3_output, JSON_PRETTY_PRINT);
  die;
}


DB::$error_handler = "false";
DB::$throw_exception_on_error = "true";
  try {

    $mysqli_price = DB::queryRaw("SELECT priceusd FROM exchange_$dbcoin order by id desc limit 1");
    $price = $mysqli_price->fetch_assoc();
    $price_output = $price["priceusd"];
    $price_final = $price_output * 10;

    $mysqli_owned = DB::query("UPDATE coinlist SET owned=%i WHERE slug=%s", 1000, $c);
    $mysqli_cash = DB::query("UPDATE coinlist SET cash=%i WHERE slug=%s", "10000", $c);
    $mysqli_profit = DB::query("UPDATE coinlist SET profit=%i WHERE slug=%s", "0.00", $c);
  } catch (MeekroDBException $e) {
    //
  }
DB::$error_handler = "update_error";
  function update_success($params) {
  $update_output = array("SUCCESS" => array("runtime" => $params['runtime'], "Query" => $params['query']));
  echo json_encode($update_output, JSON_PRETTY_PRINT);
}

?>
