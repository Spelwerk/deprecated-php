<?php global $form, $component, $curl, $sitemap, $system, $user;

global $milestone;

$component->returnButton($milestone->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $milestone->postAttribute();
        break;

    case 'delete':
        $milestone->deleteAttribute();
        break;
}
?>