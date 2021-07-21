<?php
/** 
 * crab.php is the simple master controller for task delegation
 * Template
 * Draft: May 19, 2021 6:20 pm
 */

//$ip = $_SERVER["REMOTE_ADDR"];


$crabclan = array(
    "1" => "ip1",
    "2" => "ip2",
    "3" => "ip3"
);

    if($crab == 1) {

        $index = array(
            "Go" => "1000"
        );
    } elseif ($crab == 2) {
        $index = array(
            "Go" => "2000"
        );
    } elseif ($crab == 3) {
        $index = array(
            "Go" => "3000"
        );
    } else {
        $index = array(
            "Go" => "4000"
        );
    }

$crawler = array(

    "ip1" => "1000",
    "ip2" => "2000",
    "ip3" => "desc limit 1000 offset 3000"
);

echo $crab;



?>