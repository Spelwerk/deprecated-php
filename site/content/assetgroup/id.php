<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $assetgroup = new AssetGroup($sitemap->index);

    $component->title($assetgroup->name);

    switch($sitemap->context)
    {
        default:
            $assetgroup->view();
            break;

        case 'edit':
            $assetgroup->put();
            break;
    }
}
?>