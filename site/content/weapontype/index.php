<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/weapontype/id.php');
} else if($index == 'create') {
    $component->title('Weapon Type');
    $system->createWeaponType();
} else {
    $component->title('Weapon Type');
    $component->returnButton('/content');
    $system->listWeaponType();
    $component->linkButton('/content/weapontype/create','Create New',false,'sw-is-green');
}
?>