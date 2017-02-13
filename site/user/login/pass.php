<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 21:40
 */
?>

<script src="/js/validation.js"></script>

<h2>Login</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--username">Username *</label>
    <input class="sw-c-input__item sw-js-validation" type="text" id="user--username" name="user--username" required/>

    <label class="sw-c-input__label" for="user--password">Password *</label>
    <input class="sw-c-input__item sw-js-validation" type="password" id="user--password" name="user--password" required/>

    <a class="sw-c-input__link" href="/user/reset">Forgotten Password?</a>

    <input type="hidden" name="post--do" value="user--login--pass"/>
    <input type="hidden" name="post--return" value="user"/>

    <input class="sw-c-submit sw-js-submit sw-is-unclickable" type="submit" value="LOGIN" disabled/>

</form>
