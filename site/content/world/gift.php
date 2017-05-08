<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Gift');

switch($sitemap->extra)
{
    default:
        $world->listGift();
        break;

    case 'add':
        $world->postGift();
        break;

    case 'delete':
        $world->deleteGift();
        break;
}
?>