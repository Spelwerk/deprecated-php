<?php global $form, $component, $user, $sitemap;

$component->title('Reset Password');

$component->wrapStart();
$form->formStart([
    'do' => 'user--password--verify',
    'return' => 'user'
]);
$form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
$form->password(true,'password','Password','Type your new password here.');
$form->formEnd(true,'Set Password');
$component->link('/user/login/reset','Code has not appeared? Resend it here!');
$component->wrapEnd();
?>