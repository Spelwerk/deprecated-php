<?php global $form, $component, $curl, $sitemap, $system, $user;

global $gift;

$component->returnButton($gift->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $gift->postSkill();
        break;

    case 'delete':
        $gift->deleteSkill();
        break;
}
?>