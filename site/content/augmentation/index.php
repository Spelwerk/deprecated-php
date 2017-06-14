<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/augmentation/id.php');
} else if($index == 'create') {
    $component->title('Augmentation');
    $system->createAugmentation();
} else {
    $component->title('Augmentation');
    $component->returnButton('/content');
    $system->listAugmentation();
    $component->linkButton('/content/augmentation/create','Create New',false,'sw-is-green');
}
?>