<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 21:59
 */
global $form, $component, $user, $sitemap;

$component->title('Logout');
$component->wrapStart();

$form->formStart();
$form->hidden('do','user--logout','post');
$form->hidden('return','user','post');
$form->formEnd(false,'Logout');
?>