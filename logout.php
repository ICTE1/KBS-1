<?php
require_once "inc/database.php";

$user = new User();

$user->logout();

header("location: ./login.php");