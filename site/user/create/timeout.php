<?php global $form, $component, $user, $sitemap;

$component->wrapStart();
$form->form([
    'special' => 'user',
    'do' => 'post--timeout',
    'return' => 'user'
]);
$form->email(true,'email','Email','Type in the email you used to create your account and we will send you a new verification email.');
$form->submit(true,'Resend');
$component->wrapEnd();
?>