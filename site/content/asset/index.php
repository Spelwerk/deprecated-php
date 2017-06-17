<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Asset');
    $system->createAsset();
} else {
    $component->title('Asset');
    $component->returnButton('/content');
    $system->listAsset();
    $component->linkButton('/content/asset/create','Create New',false,'sw-is-green');
}
?>