<?php
require_once "inc/package.php";

$user = new User();

$user->logout();

header("location: ./login.php");