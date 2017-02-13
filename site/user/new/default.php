<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 14:27
 */
?>

<script src="/js/user_new.js"></script>

<h2>Add New User</h2>

<form action="/post.php" method="post">

    <label class="sw-c-input__label" for="user--email">Email *</label>
    <input class="sw-c-input__item" type="email" id="user--email" name="user--email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" placeholder="e@mail.com" required/>
    <div class="sw-c-input__validation sw-js-email-validation sw-is-invalid"></div>

    <label class="sw-c-input__label" for="user--username">Username *</label>
    <input class="sw-c-input__item sw-js-validation" type="text" id="user--username" name="user--username" required/>

    <label class="sw-c-input__label" for="user--password">Password *</label>
    <input class="sw-c-input__item" type="password" id="user--password" name="user--password" required/>

    <label class="sw-c-input__label" for="user--password2">Password Validation *</label>
    <input class="sw-c-input__item" type="password" id="user--password2" name="user--password2" required/>
    <div class="sw-c-input__validation sw-js-password-validation sw-is-invalid"></div>

    <label class="sw-c-input__label" for="user--firstname">First Name</label>
    <input class="sw-c-input__item" type="text" id="user--firstname" name="user--firstname"/>

    <label class="sw-c-input__label" for="user--surname">Surname</label>
    <input class="sw-c-input__item" type="text" id="user--surname" name="user--surname"/>

    <?php /*
    <div class="sw-c-input__label">Two Factor Login?</div>
    <div class="sw-c-input__bool">
        <label for="user--twofactor--1">
            <div class="sw-c-input__bool__item sw-js-input-item">
                <img class="sw-js-radio-false" src="/img/radio-false.png"/>
                <img class="sw-js-radio-true sw-is-hidden" src="/img/radio-true.png"/>
                <div class="sw-c-input__bool__text">Yes</div>
                <input class="sw-js-input-radio sw-is-hidden" type="radio" name="user--twofactor" id="user--twofactor--1" value="1"/>
            </div>
        </label>
        <label for="user--twofactor--0">
            <div class="sw-c-input__bool__item sw-js-input-item">
                <img class="sw-js-radio-false sw-is-hidden" src="/img/radio-false.png"/>
                <img class="sw-js-radio-true" src="/img/radio-true.png"/>
                <div class="sw-c-input__bool__text">No</div>
                <input class="sw-js-input-radio sw-is-hidden" type="radio" name="user--twofactor" id="user--twofactor--0" value="0" checked/>
            </div>
        </label>
    </div>
    */ ?>

    <input type="hidden" name="post--do" value="user--new"/>
    <input type="hidden" name="post--return" value="user/new/verify"/>

    <input class="sw-c-submit__button sw-js-submit sw-is-unclickable" type="submit" value="ADD" disabled/>

</form>