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

$component->title('Cheat '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php if($sitemap->context == 'gift'): ?>

        <?php
        global $form;

        $system = new System();

        $component->h2('Gift');

        $system->person_selectCharacteristic($person, 1, 1);
        ?>

        <script src="/js/validation.js"></script>

    <?php endif; ?>

    <?php if($sitemap->context == 'imperfection'): ?>

        <?php
        global $form;

        $system = new System();

        $component->h2('Imperfection');

        $system->person_selectCharacteristic($person, 0, 1);
        ?>

        <script src="/js/validation.js"></script>

    <?php endif; ?>

    <?php if(!$sitemap->context): ?>

        <?php
        $list = $person->getCharacteristic();

        $component->h2('Characteristic');

        $component->wrapStart();

        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'characteristic');
        }

        $component->linkButton($person->siteLink.'/cheat/characteristic/gift','Add Gift');
        $component->linkButton($person->siteLink.'/cheat/characteristic/imperfection','Add Imperfection');
        $component->wrapEnd();
        ?>

    <?php endif; ?>

<?php endif; ?>