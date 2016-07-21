<div class="signin_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($signin_notification)): ?>
        <div class="ntf_messages">
           <p><?php echo $signin_notification ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open("signin"); ?>
    <input type="text" name="usr_email_uname" placeholder="enter username or email address" title="username or email" />
    <input type="password" name="usr_password" placeholder="password" title="your password" />
    <button class="btn-submit" type="submit">Sign in</button>
    <a class="btn-signup" href="<?php echo base_url('register')?>" title="sign up">Sign up</a>
    <a class="btn-forgotpassword" href="#" title="sign up">Forgot Password</a>
    <?php echo form_close();?>
</div>