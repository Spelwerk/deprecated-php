<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 14:32
 */
global $sitemap;
?>

<script src="/js/user_pass.js"></script>

<h2>Type New Password</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--verification">Verification Code *</label>
    <input class="sw-c-input__item sw-js-validation" type="text" id="user--verification" name="user--verification" value="<?php echo $sitemap->hash;?>" required/>

    <label class="sw-c-input__label" for="user--password">Password *</label>
    <input class="sw-c-input__item" type="password" id="user--password" name="user--password" required/>

    <label class="sw-c-input__label" for="user--password2">Password Validation *</label>
    <input class="sw-c-input__item" type="password" id="user--password2" name="user--password2" required/>
    <div class="sw-c-input__validation sw-js-password-validation sw-is-invalid"></div>

    <input type="hidden" name="post--do" value="user--pass--verify"/>
    <input type="hidden" name="post--return" value="user"/>

    <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="SET"/>

</form>
