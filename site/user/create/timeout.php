<?php global $form, $component, $user, $sitemap;

$component->wrapStart();
$form->formStart([
    'do' => 'user--post--timeout',
    'return' => 'user'
]);
$form->email(true,'email','Email','Type in the email you used to create your account and we will send you a new verification email.');
$form->formEnd(true,'Resend');
$component->wrapEnd();
?>