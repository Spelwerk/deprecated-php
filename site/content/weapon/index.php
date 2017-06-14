<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/weapon/id.php');
} else if($index == 'create') {
    $component->title('Weapon');
    $system->createWeapon();
} else {
    $component->title('Weapon');
    $component->returnButton('/content');
    $system->listWeapon();
    $component->linkButton('/content/weapon/create','Create New',false,'sw-is-green');
}
?>