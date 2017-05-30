<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Gift');

    if($sitemap->extra2 == 'add') {
        $person->postImperfection(true);
    } else {
        $component->wrapStart();

        $list = $person->getImperfection();

        foreach($list as $item) {
            $person->buildRemoval('imperfection', $item->id, $item->name, $item->icon);
        }

        $component->linkButton($person->siteLink.'/cheat/imperfection/add','Add Imperfection');
        $component->wrapEnd();
    }
}
?>