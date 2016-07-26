<div class="me_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($me_notification)): ?>
        <div class="ntf_messages">
            <p><?php echo $me_notification; ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open('me')?>
        <input type="text" name="usr_fname" placeholder="your first name" title="first name" value="<?php if(isset($usr_fname)){ echo $usr_fname; }?>" />
        <input type="text" name="usr_lname" placeholder="your last name" title="last name" value="<?php if(isset($usr_lname)){ echo $usr_lname; }?>" />
        <input type="text" name="usr_add1" placeholder="address 1" title="first address" value="<?php if(isset($usr_add1)){ echo $usr_add1; }?>" />
        <input type="text" name="usr_add2" placeholder="address 2" title="second address" value="<?php if(isset($usr_add2)){ echo $usr_add2; }?>" />
        <input type="text" name="usr_add3" placeholder="address 3" title="third address" value="<?php if(isset($usr_add3)){ echo $usr_add3; }?>" />
        <input type="text" name="usr_town_city" placeholder="town/city" title="city" value="<?php if(isset($usr_town_city)){ echo $usr_town_city; }?>" />
        <input type="text" name="usr_zip_pcode" placeholder="zip code" title="zip code" value="<?php if(isset($usr_zip_pcode)){ echo $usr_zip_pcode; }?>" />

        <input type="text" name="usr_uname" placeholder="your username" title="your username" value="<?php if(isset($usr_uname)){ echo $usr_uname; }?>" />
        <input type="email" name="usr_email" placeholder="your email address" title="your email address" value="<?php if(isset($usr_email)){ echo $usr_email; }?>" />
        <button type="submit">Save</button>
    <?php echo form_close(); ?>
</div>