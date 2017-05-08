<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Protection');

switch($sitemap->extra)
{
    default:
        $world->listProtection();
        break;

    case 'add':
        $world->postProtection();
        break;

    case 'delete':
        $world->deleteProtection();
        break;
}
?>