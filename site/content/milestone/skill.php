<?php global $form, $component, $curl, $sitemap, $system, $user;

global $milestone;

$component->returnButton($milestone->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $milestone->postSkill();
        break;

    case 'delete':
        $milestone->deleteSkill();
        break;
}
?>