<?php
require_once "inc/package.php";

if ( isset ($_POST['payment']) ){
    $view = 'views/betaald.php';
} else{
    $view ='views/betaalpagina.php';
}

include 'template.php';
