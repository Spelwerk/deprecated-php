<?php global $form, $component, $curl, $sitemap, $system, $user;

global $species;

$component->returnButton($species->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default:
        $species->listAttribute();
        break;

    case 'add':
        $species->postAttribute();
        break;

    case 'delete':
        $species->deleteAttribute();
        break;
}
?>