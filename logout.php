<?php
require_once "inc/database.php";

$wwic = new wwic_db;

$wwic->logout();

header("location: ./login.php");