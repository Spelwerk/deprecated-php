<?php global $component, $person, $sitemap;

if($person->isOwner) {
    if($sitemap->extra2 == 'add') {
        $person->postProtection();
    } else {
        $list = $person->getProtection();
        $component->h1('Protection');
        if(isset($list)) {
            foreach($list as $item) {
                $person->buildRemoval('protection', $item->id, $item->name, $item->icon);
            }
        }

        $component->linkButton($person->siteLink.'/edit/protection/add','Add');
    }
}
?>