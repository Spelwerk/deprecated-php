<?php global $form, $component, $curl, $sitemap, $system, $user;

global $background;

$component->returnButton($background->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default:
        $background->listSkill();
        break;

    case 'add':
        $background->postSkill();
        break;

    case 'delete':
        $background->deleteSkill();
        break;
}
?>