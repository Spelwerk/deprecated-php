<?php global $form, $component, $curl, $sitemap, $system, $user;

global $manifestation;

$component->returnButton($manifestation->siteLink);
switch($sitemap->extra)
{
    default:
        $manifestation->listFocus();
        break;

    case 'add':
        $manifestation->postFocus();
        break;

    case 'delete':
        $manifestation->deleteFocus();
        break;
}
?>