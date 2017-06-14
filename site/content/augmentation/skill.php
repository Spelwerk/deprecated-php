<?php global $form, $component, $curl, $sitemap, $system, $user;

global $augmentation;

$component->returnButton($augmentation->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default:
        $augmentation->listSkill();
        break;

    case 'add':
        $augmentation->postSkill();
        break;

    case 'delete':
        $augmentation->deleteSkill();
        break;
}
?>