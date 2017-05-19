<?php global $form, $component, $curl, $sitemap, $system, $user;

global $manifestation;

$component->returnButton($manifestation->siteLink);
switch($sitemap->extra)
{
    default:
        $manifestation->listDoctrine();
        break;

    case 'add':
        $manifestation->postDoctrine();
        break;

    case 'delete':
        $manifestation->deleteDoctrine();
        break;
}
?>