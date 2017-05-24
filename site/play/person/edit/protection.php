<?php global $component, $person, $sitemap;

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    $component->h2('Protection');

    if($sitemap->context2 == 'add') {
        $person->postProtection();
    } else {
        if(isset($list)) {
            foreach($list as $item) {
                $person->buildRemoval('protection', $item->id, $item->name, $item->icon);
            }
        }

        $component->linkButton($person->siteLink.'/edit/protection/add','Add');
    }
}
?>