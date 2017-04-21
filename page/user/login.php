<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 18:58
 */
global $form, $component, $user, $sitemap;
?>

<?php
$component->title('Login');
$component->wrapStart();

if(!$sitemap->context) {
    $form->formStart([
        'do' => 'user--login--password',
        'return' => 'user/me'
    ]);
    $form->email(true,'email','Email');
    $form->password(true,'password','Password');
    $form->formEnd(true,'Login');

    $component->linkAction('/user/login/email','Login with email instead','Login by using an email verification code','/img/login-email-w.png');
    $component->link('/user/login/reset','Forgotten Password? Reset Here');
}

if($sitemap->context == 'email') {
    $form->formStart([
        'do' => 'user--login--email',
        'return' => 'user/me'
    ]);
    $form->email(true,'email','Email','We will send you an email with a secure Verification Code that you will use to verify.');
    $form->formEnd(false,'Login');
}

if($sitemap->context == 'reset') {
    $form->formStart([
        'do' => 'user--reset',
        'return' => 'user/login'
    ]);

    $form->email(true,'email','Email','We will send you an email with a secure Verification Code that you will use to reset your password.');
    $form->formEnd(false,'Reset');
}

$component->wrapEnd();

?>

<script src="/js/validation.js"></script>
