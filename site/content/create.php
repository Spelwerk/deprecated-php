<?php global $form, $component, $curl, $sitemap, $system, $user;

switch($sitemap->context)
{
    default:
        $component->title('Create');
        $component->linkButton('/content/create/expertise','Expertise');
        $component->linkButton('/content/create/gift','Gift');
        $component->linkButton('/content/create/imperfection','Imperfection');
        $component->linkButton('/content/create/skill','Skill');
        $component->linkButton('/content/create/species','Species');
        $component->linkButton('/content/create/world','World');
        break;

    case 'expertise':
        $system->createExpertise();
        break;

    case 'gift':
        $system->createGift();
        break;

    case 'imperfection':
        $system->createImperfection();
        break;

    case 'skill':
        $system->createSkill();
        break;

    case 'species':
        $system->createSpecies();
        break;

    case 'world':
        $system->createWorld();
        break;
}
?>