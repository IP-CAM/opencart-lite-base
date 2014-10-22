<fieldset>
    <div class="left">
        <h2><?php echo $text_your_details; ?></h2>

    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="firstname" placeholder="<?php echo $entry_firstname; ?>" value="<?php echo $firstname; ?>" required />
                         <i class="fa fa-user"></i> </span>
    </div>
    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="lastname" placeholder="<?php echo $entry_lastname; ?>" value="<?php echo $lastname; ?>" required />
                         <i class="fa fa-users"></i> </span>
    </div>
    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>" required />
                         <i class="fa fa-envelope"></i> </span>
    </div>
    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="telephone" placeholder="<?php echo $entry_telephone; ?>" value="<?php echo $telephone; ?>" required />
                         <i class="fa fa-phone"></i> </span>
    </div>
        <div style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;"> <?php echo $entry_customer_group; ?><br />
            <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } else { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } ?>
            <?php } ?>
            <br />
        </div>

    </div>

    <div class="right">
        <h2><?php echo $text_your_address; ?></h2>
    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="city" placeholder="<?php echo $entry_city ?>" value="<?php echo $city; ?>" required />
                     <i class="fa fa-building-o"></i> </span>
    </div>
    <div class="form-group">
                     <span class="input-icon">
                    <input type="text" class="form-control" name="address" placeholder="<?php echo $entry_address; ?>" value="<?php echo $address; ?>" required />
                    <i class="fa fa-map-marker"></i> </span>
    </div>
    <div class="form-group">
                    <span class="input-icon">
                    <input type="text" class="form-control" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" required />
                        <i class="fa fa-paperclip"></i> </span>
    </div>
    <div class="form-group">
        <label for="country_id"><?php echo $entry_country; ?></label>
        <div class="input-group">
            <span class="input-group-addon"> <i class="fa  fa-flag"></i> </span>
            <select class="form-control" class="col-md-6" id="e1" name="country_id">
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="zone_id"><?php echo $entry_zone; ?></label>
        <div class="input-group">
            <span class="input-group-addon"> <i class="fa  fa-flag-checkered"></i> </span>
            <select class="form-control" id="e2" name="zone_id">
            </select>
        </div>
    </div>
    </div>

    <div class="buttons">
        <div class="right">
            <button id="button-guest-billing" class="btn btn-primary pull-right">
                <?php echo $button_continue; ?> <i class="fa fa-arrow-circle-right"></i>
            </button>
        </div>
    </div>
</fieldset>
<br />
<br />
<script type="text/javascript"><!--
            $('select[name=\'country_id\']').bind('change', function() {
                $.ajax({
                    url: 'index.php?route=checkout/billing/country&country_id=' + this.value,
                    dataType: 'json',
                    beforeSend: function() {
                        $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
                    },
                    complete: function() {
                        $('.wait').remove();
                    },
                    success: function(json) {
                        if (json['postcode_required'] == '1') {
                            $('#postcode-required').show();
                        } else {
                            $('#postcode-required').hide();
                        }

                        html = '<option value=""><?php echo $text_select; ?></option>';

                        if (json['zone'] != '') {

                            for (i = 0; i < json['zone'].length; i++) {
                                html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                                if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                                    html += ' selected="selected"';
                                }

                                html += '>' + json['zone'][i]['name'] + '</option>';
                            }
                        } else {
                            html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                        }

                        $('select[name=\'zone_id\']').html(html);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            });

    $('select[name=\'country_id\']').trigger('change');
//--></script>