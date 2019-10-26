<?php

require_once "meekrodb.php";
date_default_timezone_set('America/New_York');
//DB::$success_handler = true;
DB::$error_handler = 'error';
DB::$success_handler = 'coingrab'; // run this function after each successful command

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');
//ini_set('Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:69.0) Gecko/20100101 Firefox/69.0');
/* Exchange seek/engine

Sep Wed 25 2019
Near complete: Sep 28 2019
Draft: Tue Oct 15 2019.

*/

$exch = $_GET["exchange"];
//$exch = "binance";
$n = 0;
$coin = $_GET["coin"];
$coini = $_GET["slug"];
$aintime = new DateTime(date("Y-m-d H:i:s"));
$intime = $aintime->format("Y-m-d H:i:s");
$uintime = $aintime->format('U');
$dbcoin = str_ireplace("-", "_", $coin); // replace -s with _s.
$tb = "exchange_$dbcoin";

function cgExchange($exch, $coin, $coini, $n, $tb, $intime, $uintime) {

$json = file_get_contents('https://api.coingecko.com/api/v3/exchanges/'.$exch.'/tickers?coin_ids='.$coin.'');

if ($json === false) {

$json_error =
  array("ERROR" =>
  array("API" =>
  array("Error" => "Unable to open stream",
    "Query" => "? $exch . ? $coin",
    "Time" => "$intime")));
echo json_encode($json_error, JSON_PRETTY_PRINT);
 }

$data = json_decode($json, true);

// general information
$exch_name = $data["name"];
$exchange_id = $data["tickers"]["$n"]["market"]["identifier"];
// start ticker breakdown
$exch_tick_base = $data["tickers"]["$n"]["base"];
$exch_tick_target = $data["tickers"]["$n"]["target"];

// last trade
$exch_tick_last_btc = $data["tickers"]["$n"]["converted_last"]["btc"];
$exch_tick_last_eth = $data["tickers"]["$n"]["converted_last"]["eth"];
$exch_tick_last_usd = $data["tickers"]["$n"]["converted_last"]["usd"];

// converted last volume
$exch_tick_volume_btc = $data["tickers"]["$n"]["converted_volume"]["btc"];
$exch_tick_volume_eth = $data["tickers"]["$n"]["converted_volume"]["eth"];
$exch_tick_volume_usd = $data["tickers"]["$n"]["converted_volume"]["usd"];


function coingrab($params) {
$coingrab_output = array("SUCCESS" => array("runtime" => $params['runtime'], "Query" => $params['query']));
echo json_encode($coingrab_output, JSON_PRETTY_PRINT);
}

function error($params) {
$err_output = array("ERROR" => array(
  "SQL" => array(
    "Error" => $params['error'],
    "Query" => $params['query']
  )
));

echo json_encode($err_output, JSON_PRETTY_PRINT);
  die; // don't want to keep going if a query broke
}


DB::$error_handler = false;
DB::$throw_exception_on_error = true;
try {
  DB::queryRaw("CREATE TABLE $tb (
      id int(10) NOT NULL auto_increment,
      exchange varchar(255),
      name varchar(255),
      coinpair varchar(255),
      pricebtc varchar(255),
      priceeth varchar(255),
      priceusd varchar(255),
      vol24btc varchar(255),
      vol24eth varchar(255),
      vol24usd varchar(255),
      humantime varchar(255),
      indexed varchar(255),
      PRIMARY KEY( `id` )
    )", "$tb");

    DB::insert("$tb", array(
      'exchange' => "$exchange_id",
      'name' => "$coini",
      'coinpair' => "$exch_tick_base/$exch_tick_target",
      'pricebtc' => "$exch_tick_last_btc",
      'priceeth' => "$exch_tick_last_eth",
      'priceusd' => "$exch_tick_last_usd",
      'vol24btc' => "$exch_tick_volume_btc",
      'vol24eth' => "$exch_tick_volume_eth",
      'vol24usd' => "$exch_tick_volume_usd",
      'humantime' => "$intime",
      'indexed' => "$uintime"
    ));

    }
    catch(MeekroDBException $e) {
    DB::insert("$tb", array(
      'exchange' => "$exchange_id",
      'name' => "$coini",
      'coinpair' => "$exch_tick_base/$exch_tick_target",
      'pricebtc' => "$exch_tick_last_btc",
      'priceeth' => "$exch_tick_last_eth",
      'priceusd' => "$exch_tick_last_usd",
      'vol24btc' => "$exch_tick_volume_btc",
      'vol24eth' => "$exch_tick_volume_eth",
      'vol24usd' => "$exch_tick_volume_usd",
      'humantime' => "$intime",
      'indexed' => "$uintime"
));

}
DB::$error_handler = "error";

}// end of cgExchange()

cgExchange("$exch", "$coin", "$coini", "$n", "$tb", "$intime", "$uintime");
?>
