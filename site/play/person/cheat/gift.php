<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Gift');

    if($sitemap->extra2 == 'add') {
        $person->postGift(true);
    } else {
        $component->wrapStart();

        $list = $person->getGift();

        foreach($list as $item) {
            $person->buildRemoval('gift', $item->id, $item->name, $item->icon);
        }

        $component->linkButton($person->siteLink.'/cheat/gift/add','Add Gift');
        $component->wrapEnd();
    }
}
?>