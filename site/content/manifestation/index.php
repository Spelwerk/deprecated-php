<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/manifestation/id.php');
} else if($index == 'create') {
    $component->title('Manifestation');
    $system->createManifestation();
} else {
    $component->title('Manifestation');
    $component->returnButton('/content');
    $system->listManifestation();
    $component->linkButton('/content/manifestation/create','Create New',false,'sw-is-green');
}
?>