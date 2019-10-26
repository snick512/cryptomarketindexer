<?php
include "meekrodb.php";
ini_set('display_errors', '0');
/* Simple crawl status change 

Oct 25 2019

*/

$toggle = $_GET["s"];
$coin = $_GET["c"];

DB::$error_handler = "false";
DB::$throw_exception_on_error = "true";


    try {
        $mysqli_result = DB::query("UPDATE coinlist SET crawl=%i WHERE slug=%s", $toggle, $coin);
    } catch (MeekroDBException $e) {

        // it broke.
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>