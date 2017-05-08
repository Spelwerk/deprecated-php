<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Background');

switch($sitemap->extra)
{
    default:
        $world->listBackground();
        break;

    case 'add':
        $world->postBackground();
        break;

    case 'delete':
        $world->deleteBackground();
        break;
}
?>