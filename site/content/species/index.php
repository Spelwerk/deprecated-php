<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/species/id.php');
} else if($index == 'create') {
    $system->createSpecies();
} else {
    $component->title('Species');
    $component->returnButton('/content');
    $system->listSpecies();
    $component->h4('Create');
    $component->linkButton('/content/species/create','Create New');
}
?>