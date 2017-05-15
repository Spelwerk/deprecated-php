<?php global $form, $component, $curl, $sitemap, $system, $user;

switch($sitemap->context)
{
    default:
        $component->title('Create');
        $component->linkButton('/content/create/background','Background');
        $component->linkButton('/content/create/bionic','Bionic');
        $component->linkButton('/content/create/expertise','Expertise');
        $component->linkButton('/content/create/focus','Focus');
        $component->linkButton('/content/create/gift','Gift');
        $component->linkButton('/content/create/imperfection','Imperfection');
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

    case 'focus':
        $system->createFocus();
        break;

    case 'gift':
        $system->createGift();
        break;

    case 'imperfection':
        $system->createImperfection();
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