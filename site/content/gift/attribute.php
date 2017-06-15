<?php global $form, $component, $curl, $sitemap, $system, $user;

global $gift;

$component->returnButton($gift->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $gift->postAttribute();
        break;

    case 'delete':
        $gift->deleteAttribute();
        break;
}
?>