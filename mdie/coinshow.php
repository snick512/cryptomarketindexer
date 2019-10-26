<?php
require_once "meekrodb.php";
include "connect.php";
//setlocale(LC_MONETARY, 'en_US');
date_default_timezone_set('America/New_York');
ini_set('display_errors', '0');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$update_s = $_GET["stotal"];
$update_c = $_GET["slug"];

DB::$error_handler = "noshow";
function noshow($params) {

  echo "<font color=\"orange\">Reloading .. Please wait ..</font>";
}

  $sql = "SELECT * FROM coinlist where crawl=1";//desc LIMIT 1
  $result = $conn->query($sql);

  echo "<div id=\"pricetable\"><table class=\"table table-hover\">";

  if ($result->num_rows > 0) {

    echo "<tr class=\"active\"><th>Coin</th><th>Exchange</th><th>Shares</th><th>Cash</th><th>Symbol</th>";
    echo "</tr><tr>";

      // output data of each row
      while($row = $result->fetch_assoc()) {

        $coinn = $row['name'];
        $coini = $row['slug'];
        $coins = $row['symbol'];
        $coinx = $row["exchange"];
        $coinc = $row["crawl"];
        $coino = number_format($row["owned"], 20);
        $coinf = number_format($row["cash"], 2);

// is this coin to be displayed?
        if ($coinc == 0) {
        // ...
        } else {



          //echo "<form action=\"\" method=\"get\"> Shares: <input type=\"text\" name=\"stotal\"> <input type=\"hidden\" name=\"slug\" value=\"$coini\"><input type=\"submit\"> </form>";



    echo "<td><font color=\"orange\">$coinn</font> [<a href=\"?remove=$coini\">r</a>] [<a href=\"history.php?c=$coini\">h</a>]</td>";
    echo "<td><font color=\"gray\">$coinx</font></td>";
    echo "<td><font color=\"green\">$coino</font><form action=\"\" method=\"get\"> <input type=\"text\" name=\"sell\" size=\"4\"> <input type=\"hidden\" name=\"sellslug\" value=\"$coini\"><input type=\"submit\" value=\"Sell\"></form> <form action=\"\" method=\"get\"> <input type=\"text\" name=\"buy\" size=\"4\"> <input type=\"hidden\" name=\"buyslug\" value=\"$coini\"><input type=\"submit\" value=\"Buy\"> </form></td>";
    echo "<td><font color=\"orange\">$$coinf</font></td>";
    echo "<td><font color=\"green\">$coins</font></td>";

echo "</tr>";
}
      }
      echo "</table></div>";
  } else {
      echo "NULL";
  }
  $conn->close();




?>
