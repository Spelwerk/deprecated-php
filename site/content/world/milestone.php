<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Milestone');

switch($sitemap->extra)
{
    default:
        $world->listMilestone();
        break;

    case 'add':
        $world->postMilestone();
        break;

    case 'delete':
        $world->deleteMilestone();
        break;
}
?>