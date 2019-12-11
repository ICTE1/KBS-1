<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php
if($deleted){
    print('<div class="alert alert-primary" role="alert"> Verlanglijst is verwijderd</div>');
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-2">
            <h1>Verlanglijsten van <?= $username?></h1>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-dark" style="table-layout: fixed; color: inherit; border-bottom: 1px solid #272727;">
    <?php foreach($wishlists as $wishlist):
    $wishlistInfo = $wwic_db->wishlistInfo($wishlist);
    ?>

        <tr>
            <td style="width: 50%">
                <h2><?= $wishlistInfo["name"] ?></h2>
            </td>
            <td style="width= 25%">
                <?php if($wishlistInfo["shared"] == 1){echo("<p class='text-right'>Gedeelde verlanglijst</p>");} ?>
            </td>
            <td style="width: 25%">
                <div style="float: right">
                    <a class="btn custom-button-primary" href="verlanglijst.php?w=<?= $wishlist?>">Bekijk</a>
                    <form method="post" class="form-inline" style="display: inline-block">
                        <input type="hidden" name="wishlist" value="<?=$wishlist?>">
                        <button type="submit" name="action" value="deleteList" class="btn custom-button-primary" ><i class="fa fa-trash-o"></i></button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?></table></div>
    <div class="row">
        <div class="col-sm-10">
            <form id="addList" method="post">
                <input type="hidden" name="user_id" value="<?=$userid ?>">
                <input type="hidden" name="action" value="addList">
                <input type="text" name="name" class="form-control" style="width: 100%" placeholder="Nieuwe verlanglijst">
            </form>
        </div>
        <div class="col-sm-2">
            <button class="btn custom-button-primary" onclick="submitOnClick('addList')">Aanmaken</button>
        </div>
    </div>


</div>
