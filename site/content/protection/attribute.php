<?php global $form, $component, $curl, $sitemap, $system, $user;

global $protection;

$component->returnButton($protection->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $protection->postAttribute();
        break;

    case 'delete':
        $protection->deleteAttribute();
        break;
}
?>