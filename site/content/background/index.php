<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/background/id.php');
} else if($index == 'create') {
    $system->createBackground();
} else {
    $component->title('Background');
    $component->returnButton('/content');
    $system->listBackground();
    $component->h4('Create');
    $component->linkButton('/content/background/create','Create New');
}
?>