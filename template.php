<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Creepster&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">

    <link rel="icon" href="public/images/favicon.ico" type="image/ico">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

    <script src="public/javascript/wishlist.js"></script>
    <script src="public/javascript/main.js"></script>
    <script src="public/javascript/functions.js"></script>

    <title>WorldWideImporters Europa</title>
</head>
<body>
    <?php
        include "views/basis/header.php";
    ?>
        <div class="content">
        <?php
            include $view;
        ?>
        </div>
    <?php
        include "views/basis/footer.php";
    ?>
</body>
</html>
