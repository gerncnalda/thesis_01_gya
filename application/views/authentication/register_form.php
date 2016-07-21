<div class="register_form">
    <?php if(validation_errors()):?>
        <div class="ntf_messages"><?php echo validation_errors(); ?></div>
    <?php endif; ?>
    <?php if(isset($signin_notification)): ?>
        <div class="ntf_messages">
            <p><?php echo $signin_notification ?></p>
        </div>
    <?php endif;?>
    <?php echo form_open("register"); ?>
        <input type="text" name="usr_fname" placeholder="first name" title="you first name" />
        <input type="text" name="usr_lname" placeholder="last name" title="you last name" />
        <input type="email" name="usr_email" placeholder="email address" title="your email address" />
        <input type="email" name="usr_email_match" placeholder="confirm email address" title="your email address" />

        <input type="text" name="usr_uname" placeholder="desired username" title="your desired name" />
        <input type="password" name="usr_password" placeholder="password" title="password" />
        <input type="password" name="usr_password_match" placeholder="confirm password" title="confirm password" />
        <button class="btn-submit" type="submit">Register</button>
    <?php echo form_close();?>
</div>