<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Manifestation');

switch($sitemap->extra)
{
    default:
        $world->listManifestation();
        break;

    case 'add':
        $world->postManifestation();
        break;

    case 'delete':
        $world->deleteManifestation();
        break;
}
?>