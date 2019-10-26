<?php
include "connect.php";

date_default_timezone_set('America/New_York');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$indextime = date("Y-m-d H:i:s");



  $sql = "SELECT * FROM coinlist";//desc LIMIT 1
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $coinn = $row['name'];
        $coini = $row['slug'];
        $coins = $row['symbol'];
        $coinx = $row["exchange"];
        $coinc = $row["crawl"];


// is the coin to be indexed?
        if ($coinc == 0) {
        //  echo "$coinn ($coini $coinx) skipped\n";
        } else {
        //  echo "Indexed: $coinn ($coini $coinx) $indextime\n";
          
        
                /*
        An artificial throttle to respect Coin Gecko's API. 
        It is possible to index up to 100 coins per minute, 
        but recommended to always have 90 or less to leave
        room
        */
        sleep(2);
          
        //  exec('curl "http:/127.0.0.1/mdie/setsim.php?coin='.$coini.'"');
          exec('curl "http://127.0.0.1/mdie/exchange.php?exchange='.$coinx.'&coin='.$coini.'&slug='.$coini.'"');

        }
      }
  } else {
      echo "NULL";
  }
  $conn->close();

?>
