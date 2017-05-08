<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Imperfection');

switch($sitemap->extra)
{
    default:
        $world->listImperfection();
        break;

    case 'add':
        $world->postImperfection();
        break;

    case 'delete':
        $world->deleteImperfection();
        break;
}
?>