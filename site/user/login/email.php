<?php global $form, $component, $user, $sitemap;

$component->wrapStart();
$form->form([
    'special' => 'user',
    'do' => 'login--email',
    'return' => 'user'
]);
$form->email(true,'email','Email','We will send you an email with a secure Verification Code that you will use to verify.');
$form->submit(false,'Login');
$component->wrapEnd();
?>