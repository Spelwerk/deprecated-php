<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/bionic/id.php');
} else if($index == 'create') {
    $system->createBionic();
} else {
    $component->title('Bionic');
    $component->returnButton('/content');
    $system->listBionic();
    $component->h4('Create');
    $component->linkButton('/content/bionic/create','Create New');
}
?>