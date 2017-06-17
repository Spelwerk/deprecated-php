<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Asset Type');
    $system->createAssetType();
} else {
    $component->title('Asset Type');
    $component->returnButton('/content');
    $system->listAssetType();
    $component->linkButton('/content/assettype/create','Create New',false,'sw-is-green');
}
?>