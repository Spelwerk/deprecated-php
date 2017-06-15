<?php global $form, $component, $curl, $sitemap, $system, $user;

global $species;

$component->returnButton($species->siteLink);
switch($sitemap->extra)
{
    default: break;

    case 'add':
        $species->postAttribute();
        break;

    case 'delete':
        $species->deleteAttribute();
        break;
}
?>