<?php global $form, $component, $curl, $sitemap, $system, $user;

global $background;

$component->returnButton($background->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default:
        $background->listAttribute();
        break;

    case 'add':
        $background->postAttribute();
        break;

    case 'delete':
        $background->deleteAttribute();
        break;
}
?>