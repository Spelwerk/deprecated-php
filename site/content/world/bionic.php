<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Bionic');

switch($sitemap->extra)
{
    default:
        $world->listBionic();
        break;

    case 'add':
        $world->postBionic();
        break;

    case 'delete':
        $world->deleteBionic();
        break;
}
?>