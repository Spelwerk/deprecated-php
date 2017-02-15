<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 16:22
 */
?>

<script src="/js/validation.js"></script>

<h2>Send Verification</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--email">Email</label>
    <input class="sw-c-input__item" type="email" id="user--email" name="user--email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" placeholder="e@mail.com" required/>

    <input type="hidden" name="post--do" value="user--new--timeout"/>
    <input type="hidden" name="post--return" value="user/new/verify"/>

    <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="SEND"/>

</form>