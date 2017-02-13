<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 13/02/2017
 * Time: 07:44
 */
?>

<script src="/js/user_verify.js"></script>

<h2>Edit User</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--email">Email</label>
    <input class="sw-c-input__item" type="email" id="user--email" name="user--email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" placeholder="e@mail.com"/>
    <div class="sw-c-input__validation sw-js-email-validation sw-is-invalid"></div>

    <label class="sw-c-input__label" for="user--firstname">First Name</label>
    <input class="sw-c-input__item" type="text" id="user--firstname" name="user--firstname"/>

    <label class="sw-c-input__label" for="user--surname">Surname</label>
    <input class="sw-c-input__item" type="text" id="user--surname" name="user--surname"/>

    <input type="hidden" name="post--do" value="user--edit"/>
    <input type="hidden" name="post--return" value="user"/>

    <input class="sw-c-submit sw-js-submit sw-is-unclickable" type="submit" value="EDIT" disabled/>

</form>