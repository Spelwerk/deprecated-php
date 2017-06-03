<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/bionic/id.php');
} else if($index == 'create') {
    $component->title('Bionic');
    $system->createBionic();
} else {
    $component->title('Bionic');
    $component->returnButton('/content');
    $system->listBionic();
    $component->linkButton('/content/bionic/create','Create New',false,'sw-is-green');
}
?>