<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php if($sitemap->thing == 'gift'): ?>

    <?php
    global $form;

    $system = new System();

    $component->h2('Gift');

    $system->person_selectCharacteristic($person, 1, 1);
    ?>

    <script src="/js/play_create.js"></script>

<?php endif; ?>

<?php if($sitemap->thing == 'imperfection'): ?>

    <?php
    global $form;

    $system = new System();

    $component->h2('Imperfection');

    $system->person_selectCharacteristic($person, 0, 1);
    ?>

    <script src="/js/play_create.js"></script>

<?php endif; ?>

<?php if(!$sitemap->thing): ?>

    <?php
    $list = $person->getCharacteristic();

    $component->h2('Characteristic');

    $component->wrapStart();

    foreach($list as $item) {
        $person->buildRemoval($item->id, $item->name, $item->icon, 'characteristic');
    }

    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/characteristic/gift','Add Gift');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/characteristic/imperfection','Add Imperfection');
    $component->wrapEnd();
    ?>

<?php endif; ?>