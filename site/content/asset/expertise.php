<?php global $form, $component, $curl, $sitemap, $system, $user;

global $augmentation;

$component->returnButton($augmentation->siteLink);
$component->h1('Expertise');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $augmentation->postExpertise();
        break;

    case 'delete':
        $augmentation->deleteExpertise();
        break;
}
?>