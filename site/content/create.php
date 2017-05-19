<?php global $form, $component, $curl, $sitemap, $system, $user;

$component->title('Create');

switch($sitemap->context)
{
    default:
        $component->linkButton('/content/create/background','Background');
        $component->linkButton('/content/create/bionic','Bionic');
        $component->linkButton('/content/create/expertise','Expertise');
        $component->linkButton('/content/create/gift','Gift');
        $component->linkButton('/content/create/imperfection','Imperfection');
        $component->linkButton('/content/create/manifestation','Manifestation');
        $component->linkButton('/content/create/milestone','Milestone');
        $component->linkButton('/content/create/skill','Skill');
        $component->linkButton('/content/create/species','Species');
        $component->linkButton('/content/create/world','World');
        break;

    case 'background':
        $system->createBackground();
        break;

    case 'bionic':
        $system->createBionic();
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

    case 'manifestation':
        $system->createManifestation();
        break;

    case 'milestone':
        $system->createMilestone();
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