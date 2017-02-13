<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 21:43
 */
?>

<script src="/js/user_verify.js"></script>

<h2>Login</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--email">Email</label>
    <input class="sw-c-input__item" type="email" id="user--email" name="user--email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" placeholder="e@mail.com" required/>
    <div class="sw-c-input__validation sw-js-email-validation sw-is-invalid"></div>

    <input type="hidden" name="post--do" value="user--login--mail"/>
    <input type="hidden" name="post--return" value="user/login/verify"/>

    <input class="sw-c-submit sw-js-submit sw-is-unclickable" type="submit" value="LOGIN" disabled/>

</form>
