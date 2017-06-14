<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/weapongroup/id.php');
} else if($index == 'create') {
    $component->title('Weapon Group');
    $system->createWeaponGroup();
} else {
    $component->title('Weapon Group');
    $component->returnButton('/content');
    $system->listWeaponGroup();
    $component->linkButton('/content/weapongroup/create','Create New',false,'sw-is-green');
}
?>