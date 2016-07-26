<div class="forgot_pwd_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($forgot_pwd_notification)): ?>
        <div class="ntf_messages">
            <p><?php echo $forgot_pwd_notification ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open("password/forgot_password"); ?>
    <input type="email" name="usr_email" placeholder="enter you email address" title="email address" />
    <button class="btn-submit" type="submit">Submit</button>
    <?php echo form_close();?>
</div>