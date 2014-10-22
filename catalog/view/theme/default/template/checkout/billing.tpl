<fieldset>
    <div class="left">
        <h2><?php echo $text_your_details; ?></h2>

        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_firstname; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="firstname"  value="<?php echo $firstname; ?>" disabled />
                         <i class="fa fa-user"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_lastname; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="lastname"  value="<?php echo $lastname; ?>" disabled />
                         <i class="fa fa-users"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_email; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="email"  value="<?php echo $email; ?>" disabled />
                         <i class="fa fa-envelope"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_telephone; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="telephone"  value="<?php echo $telephone; ?>" disabled />
                         <i class="fa fa-phone"></i> </span>
        </div>

    </div>

    <div class="right">
        <h2><?php echo $text_your_address; ?></h2>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_city; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="city" value="<?php echo $address['city'] ?>" disabled />
                     <i class="fa fa-building-o"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_address; ?>">
                     <span class="input-icon">
                    <input type="text" class="form-control" name="address" value="<?php echo $address['address'] ?>" disabled />
                    <i class="fa fa-map-marker"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_postcode; ?>">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="postcode" value="<?php echo $address['postcode']; ?>" disabled />
                        <i class="fa fa-paperclip"></i> </span>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_country; ?>">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa  fa-flag"></i> </span>
                <input type="text" class="form-control" name="postcode" value="<?php echo $address['country']; ?>" disabled />

            </div>
        </div>
        <div class="form-group tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo $entry_zone; ?>">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa  fa-flag-checkered"></i> </span>
                <input type="text" class="form-control" name="postcode" value="<?php echo $address['zone']; ?>" disabled />

            </div>
        </div>
    </div>
    <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
    <div class="buttons">
        <div class="right">
            <button id="button-billing" class="btn btn-primary pull-right">
                <?php echo $button_continue; ?> <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </div>
</fieldset>
<script type="text/javascript">
    runTooltips();
</script>
