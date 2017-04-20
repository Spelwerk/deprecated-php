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
    $form->formStart([
        'do' => 'person--wound',
        'id' => $person->id,
        'secret' => $person->secret,
        'return' => 'play/person/id',
        'returnid' => 'wound',
        'context' => 'wound'
    ]);
    $form->varchar(true, 'name', 'Short Description', 'A wound is significant damage that you have taken. It can either be serious or lethal.');
    $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>