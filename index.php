<?php
require_once "inc/database.php";

session_start();
$wwi = new wwi_db();

$view = "views/home.php";
include "template.php";