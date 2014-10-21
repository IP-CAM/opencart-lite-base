<fieldset>
    <div class="left">
        <h2><?php echo $text_your_details; ?></h2>

        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="firstname"  value="<?php echo $firstname; ?>" required />
                         <i class="fa fa-user"></i> </span>
        </div>
        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="lastname"  value="<?php echo $lastname; ?>" required />
                         <i class="fa fa-users"></i> </span>
        </div>
        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="email"  value="<?php echo $email; ?>" required />
                         <i class="fa fa-envelope"></i> </span>
        </div>
        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="telephone"  value="<?php echo $telephone; ?>" required />
                         <i class="fa fa-phone"></i> </span>
        </div>

    </div>

    <div class="right">
        <h2><?php echo $text_your_address; ?></h2>
        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="city" value="<?php echo $address['city'] ?>" required />
                     <i class="fa fa-building-o"></i> </span>
        </div>
        <div class="form-group">
                     <span class="input-icon">
                    <input type="text" class="form-control" name="address" value="<?php echo $address['address'] ?>" required />
                    <i class="fa fa-map-marker"></i> </span>
        </div>
        <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="postcode" value="<?php echo $address['postcode']; ?>" required />
                        <i class="fa fa-paperclip"></i> </span>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa  fa-flag"></i> </span>
                <input type="text" class="form-control" name="postcode" value="<?php echo $address['country']; ?>" required />

            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa  fa-flag-checkered"></i> </span>
                <input type="text" class="form-control" name="postcode" value="<?php echo $address['zone']; ?>" required />

            </div>
        </div>
    </div>

    <div class="buttons">
        <div class="right">
            <input type="button" value="<?php echo $button_continue; ?>" id="button-billing" class="btn btn-primary" />
        </div>
    </div>
</fieldset>
