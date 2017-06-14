<?php global $form, $component, $curl, $sitemap, $system, $user;

global $augmentation;

$component->returnButton($augmentation->siteLink);
$component->h1('Attribute');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $augmentation->postAttribute();
        break;

    case 'delete':
        $augmentation->deleteAttribute();
        break;
}
?>