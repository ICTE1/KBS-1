<?php
require_once "inc/database.php";

if ( isset ($_POST['payment']) ){
    $view = 'views/betaald.php';
} else{
    $view ='views/betaalpagina.php';
}

include 'template.php';
