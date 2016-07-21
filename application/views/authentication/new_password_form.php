<div class="signin_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($new_pwd_notification)): ?>
        <div class="ntf_messages">
            <p><?php echo $new_pwd_notification ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open("password"); ?>
    <input type="text" name="usr_email_uname" placeholder="enter username or email address" title="username or email" />
    <input type="password" name="usr_password" placeholder="password" title="your password" />
    <button class="btn-submit" type="submit">Submit</button>
    <?php echo form_close();?>
</div>