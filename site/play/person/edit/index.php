<?php global $component, $person, $sitemap;

switch($sitemap->extra) {
    default:
        $component->wrapStart();

        $component->linkButton($person->siteLink.'/edit/ammunition','Ammunition');
        $component->linkButton($person->siteLink.'/edit/attribute','Attribute');

        if($person->world->augmentationExists) {
            $component->linkButton($person->siteLink.'/edit/augmentation','Augmentation');
        }

        if($person->world->bionicExists) {
            $component->linkButton($person->siteLink.'/edit/bionic','Bionic');
        }

        $component->linkButton($person->siteLink.'/edit/description','Description');

        if($person->isSupernatural) {
            $component->linkButton($person->siteLink.'/edit/doctrine', 'Doctrine');
        }

        $component->linkButton($person->siteLink.'/edit/experience','Experience');
        $component->linkButton($person->siteLink.'/edit/expertise','Expertise');
        $component->linkButton($person->siteLink.'/edit/money','Money');
        //$component->linkButton($person->siteLink.'/edit/milestone','Milestone');
        $component->linkButton($person->siteLink.'/edit/protection','Protection');
        $component->linkButton($person->siteLink.'/edit/rations','Rations');
        $component->linkButton($person->siteLink.'/edit/skill','Skill');
        $component->linkButton($person->siteLink.'/edit/weapon','Weapon');
        //$component->linkButton($person->siteLink.'/cheat','Cheat',true);

        $component->wrapEnd();
        break;

    case 'ammunition':
        $person->putAmmunition();
        break;

    case 'attribute':
        $person->postAttribute();
        break;

    case 'augmentation':
        require_once('augmentation.php');
        break;

    case 'bionic':
        $person->postBionic();
        break;

    case 'description':
        $person->put();
        break;

    case 'doctrine':
        $person->postDoctrine();
        break;

    case 'experience':
        $person->putExperience();
        break;

    case 'expertise':
        $person->postExpertise();
        break;

    case 'money':
        $person->putMoney();
        break;

    case 'protection':
        require_once('protection.php');
        break;

    case 'rations':
        $person->putRations();
        break;

    case 'skill':
        $person->postSkill();
        break;

    case 'weapon':
        require_once('weapon.php');
        break;
}
?>
