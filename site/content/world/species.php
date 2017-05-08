<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Species');

switch($sitemap->extra)
{
    default:
        $world->listSpecies();
        break;

    case 'add':
        $world->postSpecies();
        break;

    case 'delete':
        $world->deleteSpecies();
        break;
}
?>