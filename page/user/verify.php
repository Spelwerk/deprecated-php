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
$form->formStart();

if($sitemap->context == 'add') {
    $form->varchar(true,'verification','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->hidden('do','user--verify--add','post');
    $form->hidden('return','user/me','post');
    $form->formEnd(false,'Verify');
}

if($sitemap->context == 'login') {
    $form->varchar(true,'verification','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->hidden('do','user--verify--login','post');
    $form->hidden('return','user/me','post');
    $form->formEnd(false,'Verify');
}

if($sitemap->context == 'reset') {
    $form->varchar(true,'verification','Verification Code','Copy and paste the code you have received via email if it has not been automatically added by clicking the email link.',null,$sitemap->hash);
    $form->password(true,'password','Password','Type your new password here.');
    $form->hidden('do','user--verify--reset','post');
    $form->hidden('return','user/me','post');
    $form->formEnd(true,'Verify');
}

$component->wrapEnd();
?>

<script src="/js/validation.js"></script>
