<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Expertise');

switch($sitemap->extra)
{
    default:
        $world->listExpertise();
        break;

    case 'add':
        $world->postExpertise();
        break;

    case 'delete':
        $world->deleteExpertise();
        break;
}
?>