<?php global $form, $component, $curl, $sitemap, $system, $user;

global $asset;

$component->returnButton($asset->siteLink);
$component->h1('Skill');

switch($sitemap->extra)
{
    default: break;

    case 'add':
        $asset->postSkill();
        break;

    case 'delete':
        $asset->deleteSkill();
        break;
}
?>