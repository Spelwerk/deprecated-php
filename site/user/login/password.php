<?php global $form, $component, $user, $sitemap;

$component->wrapStart();
$form->form([
    'special' => 'user',
    'do' => 'login--password',
    'return' => 'user'
]);
$form->email(true,'email','Email');
$form->password(true,'password','Password');
$form->submit(true,'Login');

$component->linkAction('/user/login/email','Login with email instead','Login by using an email verification code','/img/login-email-w.png');
$component->link('/user/password/reset','Forgotten Password? Reset Here');
$component->wrapEnd();
?>