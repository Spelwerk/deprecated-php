<?php global $form, $component, $user, $sitemap;

$component->h1('Verify your account');

$component->wrapStart();
$form->formStart([
    'do' => 'user--post--verify',
    'return' => 'user'
]);
$form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
$form->password(true,'password','Password','We recommend you to use a long and safe password, preferably unique to every site you visit - including this one. You can do this by having a password manager.');
$form->varchar(true,'displayname','Display Name','Your Display Name will not be used for login, but instead as public identification of you.');
$form->varchar(false,'firstname','First Name','Your first name.');
$form->varchar(false,'surname','Surname','Your surname.');
$form->formEnd(false,'Verify');
$component->link('/user/new/timeout','Code has not appeared? Resend it here!');
$component->wrapEnd();
?>