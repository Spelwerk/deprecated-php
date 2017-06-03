<?php global $form, $component, $user, $sitemap;

$component->wrapStart();
$form->formStart([
    'do' => 'user--login--verify',
    'return' => 'user'
]);
$form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
$form->formEnd(false,'Verify');
$component->link('/user/login/reset','Code has not appeared? Resend it here!');
$component->wrapEnd();
?>