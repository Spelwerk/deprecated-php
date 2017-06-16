<?php global $form, $component, $curl, $sitemap, $system, $user;

global $story;

$component->returnButton($story->siteLink);
$component->h1('Person');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $story->postPerson();
        break;

    case 'delete':
        $story->deletePerson();
        break;
}
?>