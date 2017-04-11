<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 08:08
 */
global $form, $sitemap, $component, $person;

require_once('./class/Person.php');
$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Add Wound');
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $component->wrapStart();
    $form->formStart();
    $form->hidden('return', 'play/person/id', 'post');
    $form->hidden('returnid', 'wound', 'post');
    $form->hidden('do', 'person--wound--add', 'post');
    $form->hidden('context', 'wound', 'post');
    $form->hidden('id', $person->id, 'post');
    $form->hidden('hash', $person->hash, 'post');
    $form->varchar(true, 'name', 'Short Description', 'A wound is significant damage that you have taken. It can either be serious or lethal.');
    $form->pick(true, 'double', 'Double Damage','Check this if you have suffered double damage.');
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>