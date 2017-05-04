<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:46
 */
global $sitemap, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    $component->wrapStart();

    //$component->linkButton($person->siteLink.'/edit/asset','Asset');

    if($person->world->augmentationExists) {
        $component->linkButton($person->siteLink.'/edit/augmentation','Augmentation');
    }

    if($person->world->bionicExists) {
        $component->linkButton($person->siteLink.'/edit/bionic','Bionic');
    }

    $component->linkButton($person->siteLink.'/edit/consumable','Consumable');
    $component->linkButton($person->siteLink.'/edit/description','Description');
    $component->linkButton($person->siteLink.'/edit/experience','Experience');
    $component->linkButton($person->siteLink.'/edit/expertise','Expertise');
    $component->linkButton($person->siteLink.'/edit/milestone','Milestone');
    $component->linkButton($person->siteLink.'/edit/protection','Protection');
    $component->linkButton($person->siteLink.'/edit/skill','Skill');

    if($person->world->softwareExists) {
        //$component->linkButton('/play/' . $person->id . '/' . $person->hash . '/edit/software', 'Software');
    }

    if($person->isSupernatural) {
        $component->linkButton('/play/' . $person->id . '/' . $person->hash . '/edit/supernatural', 'Supernatural');
    }

    $component->linkButton($person->siteLink.'/edit/weapon','Weapon');
    $component->linkButton($person->siteLink.'/cheat','Cheat',true);

    $component->wrapEnd();
}
?>
