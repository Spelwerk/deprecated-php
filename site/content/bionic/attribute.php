<?php global $form, $component, $curl, $sitemap, $system, $user;

global $bionic;

$component->returnButton($bionic->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default:
        $bionic->listAttribute();
        break;

    case 'add':
        $bionic->postAttribute();
        break;

    case 'delete':
        $bionic->deleteAttribute();
        break;
}
?>