<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $assettype = new AssetType($sitemap->index);

    $component->title($assettype->name);

    switch($sitemap->context)
    {
        default:
            $assettype->view();
            break;

        case 'edit':
            $assettype->put();
            break;
    }
}
?>