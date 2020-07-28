<?php
die;
error_reporting(E_ALL);
ini_set("display_errors", 1);
require __DIR__ . "/vendor/autoload.php";
$home = new redirect\src\Controllers\HomeController();
if(count($_GET)==0) {
    $home->index();
}
else if($_GET['key']=="generate"){
    $home->store($_GET['link']);
}
else if(preg_match('/^[a-zA-Z]{4}$/', $_GET['key']))
{
    $home->redirect($_GET['key']);
}