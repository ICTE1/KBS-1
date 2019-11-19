<?php
require_once "inc/database.php";

session_start();

$wwic = new wwic_db;

$wwic->logout();

header("location: ./login.php");