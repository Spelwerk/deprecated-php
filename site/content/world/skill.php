<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default:
        $world->listSkill();
        break;

    case 'add':
        $world->postSkill();
        break;

    case 'delete':
        $world->deleteSkill();
        break;
}
?>