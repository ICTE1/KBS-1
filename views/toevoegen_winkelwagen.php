  <form method="post" action="toevoegen_winkelwagen.php" class="form-inline">
        <input type="number" style="width: 60px;" class='form-control text-right' name="aantal"  min="1" value="<?php print($aantal);?>">
        <input type="hidden" name="hiddenToevoegen">
        <input type="submit" class="btn btn-primary" value="Update winkelwagen">
    </form>