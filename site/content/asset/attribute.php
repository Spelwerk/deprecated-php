<?php global $form, $component, $curl, $sitemap, $system, $user;

global $asset;

$component->returnButton($asset->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $asset->postAttribute();
        break;

    case 'delete':
        $asset->deleteAttribute();
        break;
}
?>