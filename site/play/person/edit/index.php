<?php global $component, $person, $sitemap;

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    switch($sitemap->extra)
    {
        default:
            $component->wrapStart();

            if($person->world->augmentationExists) {
                $component->linkButton($person->siteLink.'/edit/augmentation','Augmentation');
            }

            if($person->world->bionicExists) {
                $component->linkButton($person->siteLink.'/edit/bionic','Bionic');
            }

            $component->linkButton($person->siteLink.'/edit/consumable','Consumable');
            $component->linkButton($person->siteLink.'/edit/description','Description');

            if($person->isSupernatural) {
                $component->linkButton($person->siteLink.'/edit/doctrine', 'Doctrine');
            }

            $component->linkButton($person->siteLink.'/edit/experience','Experience');
            $component->linkButton($person->siteLink.'/edit/expertise','Expertise');
            //$component->linkButton($person->siteLink.'/edit/milestone','Milestone');
            $component->linkButton($person->siteLink.'/edit/protection','Protection');
            $component->linkButton($person->siteLink.'/edit/skill','Skill');
            $component->linkButton($person->siteLink.'/edit/weapon','Weapon');
            //$component->linkButton($person->siteLink.'/cheat','Cheat',true);

            $component->wrapEnd();
            break;

        case 'augmentation':
            require_once('augmentation.php');
            break;

        case 'bionic':
            $component->h2('Bionic');
            $component->subtitle('Once attached. Bionics cannot be removed.');
            $person->postBionic();
            break;

        case 'consumable':
            require_once('consumable.php');
            break;

        case 'description':
            require_once('description.php');
            break;

        case 'doctrine':
            $component->h2('Doctrine');
            $person->postDoctrine();
            break;

        case 'experience':
            require_once('experience.php');
            break;

        case 'expertise':
            $component->h2('Purchase Expertise');
            $exp = $person->getAttribute(null, $person->world->experienceAttribute)[0];
            $person->postExpertise();
            break;

        case 'protection':
            require_once('protection.php');
            break;

        case 'skill':
            $component->h2('Skill');
            $person->postSkill();
            break;

        case 'weapon':
            require_once('weapon.php');
            break;
    }
}
?>
