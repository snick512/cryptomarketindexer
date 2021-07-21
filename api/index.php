<?php
date_default_timezone_set('America/New_York');
//DB::$success_handler = true;
//DB::$error_handler = 'error';
//DB::$success_handler = 'coingrab'; // run this function after each successful command

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//header('Content-Type: application/json');

/* 
Basic CMI API to build custom clients. 
This basic outputs will access the SQL database 
and then display the results to the client.

Started Monday March 29, 2021
(p.s., I know this isn't the way)


Todo: 
1) Price and associated exchange
2) Short/Long History with timeframe selection
3) Exchange selection

- Monday May 3, 2021. Started working on timeframe searching

*/ 

include "../mdie/meekrodb.php";

$coin = $_GET["coin"];
$a = $_GET["a"];
$dbcoin = str_ireplace("-", "_", $coin);

switch ($a):

    /**
     * price
     * Example call: curl https://127.0.0.1/api/?a=price&coin=dogecash
     * 
     * {
     * "id": "83915",
     *   "name": "dogecash",
     *   "exchange": "StakeCube",
     *   "coin_pair": "DOGEC/SCC",
     *   "price_usd": "0.087903",
     *   "24h_volume": "201.18",
     *   "at_time": "2021-05-26 16:33:02"
     * }
     * 
     * $coin = dogecash
     * $a = price
     * 
     */
        case "price":
            
            header('Content-Type: application/json');

            //echo "";
            try {
             
                    $mysqli_price = DB::queryRaw("SELECT id,exchange,name,coinpair,priceusd,vol24usd,humantime from exchange_$dbcoin order by id desc limit 1");
                    $price = $mysqli_price->fetch_assoc();
                    $exchn = $price["exchange"];
                   $exchange_name = DB::queryRaw("SELECT exchangename from exchanges where exchange='$exchn'");
                   $exchn_out = $exchange_name->fetch_assoc();
                   $exchn_proper = $exchn_out["exchangename"];

                    $info = array(
                        "id" => $price["id"],
                        "name" => $price["name"],
                        "exchange" => $exchn_proper,
                        "coin_pair" => $price["coinpair"],
                        "price_usd" => $price["priceusd"],
                        "24h_volume" => $price["vol24usd"],
                        "at_time" => $price["humantime"]
                    );

                echo json_encode($info);
                
            } catch(MeekroDBException $e) {
                    echo "||Failed||";
                  }
        // end of price
                  break;

        // timeframe
        case "frame":

            /**
             * frame
             * Example call: curl https://127.0.0.1/api/?a=frame&b=2021-03-21&c=2021-04-21&coin=bitcoin
             * 
             */
                try {

                    $fone = $_GET["b"];
                    $ftwo = $_GET["c"];

                    //select * from exchange_bitcoin where humantime between "2021-03-20 00:00:00" and "2021-04-20 23:59:59" limit 5;
                    $mysqli_frame = DB::queryRaw("SELECT * from exchange_$dbcoin where humantime between '$fone 00:00:00' and '$ftwo 23:59:59'");


 // Working, yet not good result

                     foreach ($mysqli_frame as $frame) {
                           // echo $frame["priceusd"]. " " .$frame["humantime"];
    
 

                           /*$info = array(
                           
                            "id" => $frame["id"],
                            "name" => $frame["name"],
                            "exchange" => $frame["exchange"],
                            "coin_pair" => $frame["coinpair"],
                            "price_usd" => $frame["priceusd"],
                            "24h_volume" => $frame["vol24usd"],
                            "at_time" => $frame["humantime"]
                        );*/
                        //echo json_encode($info);
echo $frame["id"]. " " .$frame["name"]. " " .$frame["exchange"]. " " .$frame["coinpair"]. " " .$frame["priceusd"]. " " .$frame["vol24usd"]. " " .$frame["humantime"];
echo "<br />";

                    }
                } catch(MeekroDBException $e) {
                    echo "||Failed||";
                  }
    
                //end of frame
                break;

    default:
        echo "Nothing selected.";
endswitch;



?>