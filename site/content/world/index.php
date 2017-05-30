<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/world/id.php');
} else if($index == 'create') {
    $system->createWorld();
} else {
    $component->title('World');
    $component->returnButton('/content');
    $system->listWorld();
    $component->h4('Create');
    $component->linkButton('/content/world/create','Create New');
}
?>