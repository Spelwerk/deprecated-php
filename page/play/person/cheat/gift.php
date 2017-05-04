<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-28
 * Time: 10:57
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Cheat '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h2('Gift');

    if($sitemap->context == 'add') {
        $person->postGift(true);
    } else {
        $component->wrapStart();

        $list = $person->getGift();

        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'gift');
        }

        $component->linkButton($person->siteLink.'/cheat/gift/add','Add Gift');
        $component->wrapEnd();
    }
}
?>

<script src="/js/validation.js"></script>
