<?php global $form, $component, $curl, $sitemap, $system, $user;

global $world;

$component->returnButton($world->siteLink);
$component->h1('Weapon');

switch($sitemap->extra)
{
    default:
        $world->listWeapon();
        break;

    case 'add':
        $world->postWeapon();
        break;

    case 'delete':
        $world->deleteWeapon();
        break;
}
?>