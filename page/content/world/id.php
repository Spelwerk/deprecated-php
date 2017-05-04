<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-25
 * Time: 06:52
 */
global $sitemap, $user, $form, $component;

require_once('./class/World.php');

$world = null;

if(isset($sitemap->id)) {
    $world = new World($sitemap->id);

    $component->title($world->name);

    $world->create();

    if($world->isCalculated) {
        $component->h1('Lists');
        $component->linkButton($world->siteLink.'/attribute','Attribute');
        $component->linkButton($world->siteLink.'/background','Background');

        if($world->bionicExists) {
            $component->linkButton($world->siteLink.'/bionic','Bionic');
        }

        $component->linkButton($world->siteLink.'/expertise','Expertise');
        $component->linkButton($world->siteLink.'/gift','Gift');
        $component->linkButton($world->siteLink.'/imperfection','Imperfection');

        if($world->supernaturalExists) {
            $component->linkButton($world->siteLink.'/manifestation','Manifestation');
        }

        $component->linkButton($world->siteLink.'/milestone','Milestone');
        $component->linkButton($world->siteLink.'/protection','Protection');
        $component->linkButton($world->siteLink.'/skill','Skill');
        $component->linkButton($world->siteLink.'/species','Species');
        $component->linkButton($world->siteLink.'/weapon','Weapon');
    }
}
?>

<script src="/js/validation.js"></script>