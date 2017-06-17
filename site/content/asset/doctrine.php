<?php global $form, $component, $curl, $sitemap, $system, $user;

global $augmentation;

$component->returnButton($augmentation->siteLink);
$component->h1('Doctrine');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $augmentation->postDoctrine();
        break;

    case 'delete':
        $augmentation->deleteDoctrine();
        break;
}
?>