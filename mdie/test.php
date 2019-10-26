<?php
include "meekrodb.php";
$mysqli_price = DB::queryRaw("SELECT name FROM coinlist order by slug limit 100");
$price = $mysqli_price->fetch_assoc();
$price_output[] = $price;
  echo json_encode($price_output, JSON_PRETTY_PRINT);


?>
