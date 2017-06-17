<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Asset Group');
    $system->createAssetGroup();
} else {
    $component->title('Asset Group');
    $component->returnButton('/content');
    $system->listAssetGroup();
    $component->linkButton('/content/assetgroup/create','Create New',false,'sw-is-green');
}
?>