<?php
require_once "meekrodb.php";
include "connect.php";
ini_set('display_errors', '0');
//setlocale(LC_MONETARY, 'en_US');
date_default_timezone_set('America/New_York');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
DB::$error_handler = "noshow";
function noshow($params) {

  echo "<font color=\"orange\">Reloading .. Please wait ..</font>";
}

  $sql = "SELECT * FROM coinlist";//desc LIMIT 1
  $result = $conn->query($sql);



  echo "<div id=\"pricetable\"><table class=\"table table-hover\">";

  if ($result->num_rows > 0) {

    echo "<tr class=\"active\"><th>Coin</th><th>Pair</th><th>Shares</th><th>Share Total</th><th>Cash</th><th>Price</th><th>24h Volume</th><th>Indexed</th>";
    echo "</tr><tr>";

      // output data of each row
      while($row = $result->fetch_assoc()) {

        $coinn = $row['name'];
        $coini = $row['slug'];
        $coins = $row['symbol'];
        $coinx = $row["exchange"];
        $coinc = $row["crawl"];
        $coino = number_format($row["owned"], 3);
        $coinf = number_format($row["cash"], 2);

// is this coin to be displayed?
        if ($coinc == 0) {
        //  echo "$coinn ($coini $coinx) skipped\n";


        } else {

// coins that are 1

          $dbcoin = str_ireplace("-", "_", $coini); // replace -s with _s.

          $mysqli_result = DB::queryRaw("SELECT * FROM exchange_$dbcoin order by id desc limit 1", "stuff");
          $showdata = $mysqli_result->fetch_assoc();
          $showdata_exchange = $showdata['exchange'];
          $showdata_coinpair = $showdata['coinpair'];
          $showdata_vol24 = number_format($showdata['vol24usd']);
          $showdata_usd = $showdata['priceusd'];
          $showdata_humantime_r = new Datetime($showdata['humantime']);
          $showdata_humantime = $showdata_humantime_r->format('h:i:s A');
          $coino_total_a = $coino * $showdata_usd;
          $coino_total = $coino_total_a;

            echo "<td><a href=\"history.php?c=$coini\"><span class=\"badge badge-pill badge-secondary\">history</span></a> <font color=\"orange\">$coinn</font></td>";
            echo "<td><font color=\"gray\">$showdata_coinpair</font></td>";
            echo "<td><font color=\"purple\"><a href=\"?buy=1&buyslug=$coini\"><span class=\"badge badge-pill badge-light\">Buy</span></a> $coino <a href=\"?sell=1&sellslug=$coini\"><span class=\"badge badge-pill badge-light\">Sell</span></a></td>";
            echo "<td><font color=\"green\">$$coino_total</font></td>";
            echo "<td><font color=\"orange\">$$coinf</font></td>";
            echo "<td><font color=\"green\">$$showdata_usd</font></td>";
            echo "<td><font color=\"orange\">$$showdata_vol24</font>/daily</td>";
            echo "<td><font color=\"white\">$showdata_humantime</font></td>";

            echo "</tr>";




}
      }
      echo "</table></div>";
  } else {
      echo "NULL";
  }
  $conn->close();

?>
