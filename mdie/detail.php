<?php
require_once "meekrodb.php";
include "connect.php";
ini_set('display_errors', '0');
//setlocale(LC_MONETARY, 'en_US');
date_default_timezone_set('America/New_York');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$coin = urldecode($_GET["c"]);
#$dbtable = str_ireplace("-", "_", $coini);

$dbcoin = str_ireplace("-", "_", $coin); // replace -s with _s.



DB::$error_handler = "coinnull";
DB::$throw_exception_on_error = true;

  function coinnull($params) {
    echo "NULL";
  }
try {
  $mysqli_result = DB::queryRaw("SELECT * FROM coinlist WHERE slug=%s", $coin);
  $showdata = $mysqli_result->fetch_assoc();
  $f_name = $showdata['name'];

} catch (MeekroDBException $e) {
  // code.
}

  $sql = "SELECT * FROM exchange_$dbcoin order by id desc limit 60";//desc LIMIT 1
  $result = $conn->query($sql);

  echo "<div id=\"pricetable\"><table class=\"table table-hover\">";


  if ($result->num_rows > 0) {


    echo "<tr class=\"active\"><th>Coin</th><th>Pair</th><th>BTC</th><th>ETH</th><th>USD</th><th>Indexed</th>";
    echo "</tr><tr>";

      // output data of each row
      while($row = $result->fetch_assoc()) {

      //  $name = $row['name'];
        $pair = $row['coinpair'];
        $pricebtc = $row['pricebtc'];
        $priceeth = $row["priceeth"];
        $priceusd = $row["priceusd"];
        $humantime_r = new Datetime($row['humantime']);
        $humantime = $humantime_r->format('h:i A');
            

        echo "<td><font color=\"orange\">$f_name</font></td>";
        echo "<td><font color=\"gray\">$pair</font></td>";
        echo "<td><font color=\"green\">$pricebtc</font></td>";
        echo "<td><font color=\"orange\">$priceeth</font></td>";
        echo "<td><font color=\"green\">$priceusd</font></td>";
        echo "<td><font color=\"white\">$humantime</font></td>";

      echo "</tr>";

      }
      echo "</table></div>";
  } else {
    echo "<p class=\"text-danger\">Coin data does not exist.</a>"; 
  }

$conn->close();

?>
