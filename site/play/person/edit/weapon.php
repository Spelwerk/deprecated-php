<?php global $component, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Weapon');

    if($sitemap->context2 == 'add') {
        $person->postWeapon();
    } else {
        $list = $person->getWeapon();

        if(isset($list)) {
            foreach($list as $item) {
                $person->buildRemoval('weapon', $item->id, $item->name, $item->icon);
            }
        }

        $component->linkButton($person->siteLink.'/edit/weapon/add','Add');
    }
}
?>