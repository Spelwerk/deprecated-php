<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 19:41
 */
global $form, $component, $user, $sitemap;
?>

<?php if($sitemap->context == 'timeout'): ?>

    <?php
    $component->title('Timeout');

    $component->wrapStart();
    $form->formStart();

    $form->hidden('do','user--add--timeout','post');
    $form->hidden('return','user/add/verify','post');

    $form->email(true,'email','Email','Type in the email you used to create your account and we will send you a new verification email.');

    $form->formEnd();
    $component->wrapEnd(true,'Add');
    ?>

<?php else: ?>

    <?php
    $component->title('Add Account');

    $component->wrapStart();
    $form->formStart();

    $form->hidden('do','user--add','post');
    $form->hidden('return','user/add/verify','post');
    $form->hidden('twofactor',0);

    $form->varchar(true,'displayname','Display Name','Your Display Name will not be used for login, but instead as public identification of you.');
    $form->email(true,'email','Email','This will be kept secret and protected, and you will use it to login.');
    $form->password(true,'password','Password','We recommend you to use a long and safe password, preferably unique to every site you visit - including this one. You can do this by having a password manager.');

    $form->formEnd(true,'Add');
    $component->wrapEnd();
    ?>

<?php endif; ?>

<script src="/js/validation.js"></script>