<?php
date_default_timezone_set('America/New_York');
//DB::$success_handler = true;
//DB::$error_handler = 'error';
//DB::$success_handler = 'coingrab'; // run this function after each successful command

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');

/* 
Basic CMI API to build custom clients. 
This basic outputs will access the SQL database 
and then display the results to the client.

Started Monday March 29, 2021
(p.s., I know this isn't the way)


Todo: 
1) Price and associated exchange
2) Short/Long History


*/ 

require_once "../mdie/meekrodb.php";

$coin = $_GET["coin"];
$a = $_GET["a"];

switch ($a):
        case "price":
            //echo "";
            try {
                $dbcoin = str_ireplace("-", "_", $coin);
             
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

        break;
    
    default:
        echo "Nothing selected.";
endswitch;



?>