<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 21:59
 */
global $form, $component, $user, $sitemap;

$component->title('Logout');
$component->h1('Logout');
$component->subtitle('Press the button below if you wish to logout of this user.');
$component->wrapStart();
$form->form([
    'special' => 'user',
    'do' => 'logout',
    'return' => 'user/login'
]);
$form->submit(false,'Logout');
?>