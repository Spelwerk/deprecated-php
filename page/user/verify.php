<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 19:00
 */
global $form, $component, $user, $sitemap;
?>

<?php
$component->title('Verify');

$component->wrapStart();

if($sitemap->context == 'new') {
    $form->formStart([
        'do' => 'user--new--verify',
        'return' => 'user/me'
    ]);
    $form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->formEnd(false,'Verify');
    $component->link('/user/new/timeout','Code has not appeared? Resend it here!');
}

if($sitemap->context == 'login') {
    $form->formStart([
        'do' => 'user--login--verify',
        'return' => 'user/me'
    ]);
    $form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->formEnd(false,'Verify');
    $component->link('/user/login/reset','Code has not appeared? Resend it here!');
}

if($sitemap->context == 'reset') {
    $form->formStart([
        'do' => 'user--reset--verify',
        'return' => 'user/me'
    ]);
    $form->varchar(true,'secret','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->password(true,'password','Password','Type your new password here.');
    $form->formEnd(true,'Verify');
    $component->link('/user/login/reset','Code has not appeared? Resend it here!');
}

$component->wrapEnd();
?>

<script src="/js/validation.js"></script>
