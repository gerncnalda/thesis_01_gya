<div  class="new_pwd_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($new_pwd_notification)): ?>
        <div class="ntf_messages">
            <p><?php echo $new_pwd_notification ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open('password/new_password')?>
    <input type="email" name="usr_email" placeholder="your email address" title="email address" />
    <input type="password" name="usr_pwd" placeholder="new password" title="your new password"/>
    <input type="password" name="usr_match_pwd" placeholder="confirm new password" title="confirm new password"/>
    <input type="hidden" name="usr_pwd_change_code" value="<?php if(isset($pwd_change_code)){ echo $pwd_change_code; }?>" />
    <button type="submit">Submit</button>
    <?php echo form_close()?>

</div>