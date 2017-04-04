<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 08:08
 */
global $form, $sitemap, $component;

$component->title('Add Wound')
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$sitemap->id.'/'.$sitemap->hash,'Return','/img/return.png'); ?>
</div>

<?php
$component->wrapStart();
$form->formStart();
$form->hidden('return', 'play', 'post');
$form->hidden('returnid', 'wound', 'post');
$form->hidden('do', 'person--wound--add', 'post');
$form->hidden('id', $sitemap->id, 'post');
$form->hidden('hash', $sitemap->hash, 'post');
$form->varchar(true, 'name', 'Short Description', 'A wound is significant damage that you have taken. It can either be serious or lethal.');
$form->pick(true, 'lethal', 'Lethal');
$form->formEnd();
$component->wrapEnd();
?>

<script src="/js/validation.js"></script>