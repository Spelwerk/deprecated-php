<?php global $form, $component, $curl, $sitemap, $system, $user;

global $bionic;

$component->returnButton($bionic->siteLink);
$component->h1('Augmentation');

switch($sitemap->extra)
{
    default:
        $bionic->listAugmentation();
        break;

    case 'add':
        $bionic->postAugmentation();
        break;

    case 'delete':
        $bionic->deleteAugmentation();
        break;
}
?>