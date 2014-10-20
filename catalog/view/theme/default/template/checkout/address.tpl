<div class="center">
<table class="table">
    <tr>
        <td><h3><?php echo $firstname; ?> <?php echo $lastname; ?></h3></td>
    </tr>

    <tr>
        <td><h3 class="center"><?php echo $telephone; ?></h3></td>
    </tr>
    <tr>
        <td>
            <h3><?php echo $address['country'] ?></h3> <h3><?php echo $address['zone'] ?></h3> <h3><?php echo $address['city'] ?></h3><br>
            <h3><?php echo $address['address']; ?></h3>
            <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
        </td>
    </tr>
    <tr>
        <td><h3><?php echo $address['postcode']; ?></h3></td>
    </tr>
</table>
    <div class="buttons">
        <div class="right">
            <input type="button" value="<?php echo $button_continue; ?>" id="button-address" class="btn btn-primary" />
        </div>
    </div>
</div>
