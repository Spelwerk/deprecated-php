<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 19:15
 */
global $form, $sitemap, $component, $person;

require_once('./class/Person.php');
$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Add Sanity');
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $component->wrapStart();
    $form->formStart();
    $form->hidden('return', 'play/person/id', 'post');
    $form->hidden('returnid', 'sanity', 'post');
    $form->hidden('do', 'person--wound--add', 'post');
    $form->hidden('context', 'sanity', 'post');
    $form->hidden('id', $person->id, 'post');
    $form->hidden('hash', $person->hash, 'post');
    $form->varchar(true, 'name', 'Short Description', 'Taking sanity damage is no easy thing. Every mind can only take so much pressure before breaking.');
    $form->pick(true, 'double', 'Double Damage','Check this if you have suffered double damage.');
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>