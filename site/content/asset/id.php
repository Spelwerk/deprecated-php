<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $asset = new Asset($sitemap->index);

    $component->title($asset->name);

    switch($sitemap->context)
    {
        default:
            $asset->view();
            break;

        case 'edit':
            $asset->put();
            break;

        case 'attribute':
            require_once('attribute.php');
            break;

        case 'doctrine':
            require_once('doctrine.php');
            break;

        case 'expertise':
            require_once('expertise.php');
            break;

        case 'skill':
            require_once('skill.php');
            break;
    }
}
?>