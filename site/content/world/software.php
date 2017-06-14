<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Software');

switch($sitemap->extra)
{
    default:
        $world->listSoftware();
        break;

    case 'add':
        $world->postSoftware();
        break;

    case 'delete':
        $world->deleteSoftware();
        break;
}
?>