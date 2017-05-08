<?php global $form, $component, $curl, $sitemap, $system, $user;

switch($sitemap->context)
{
    default:
        $component->title('Create');
        $component->linkButton('/content/create/species','Species');
        $component->linkButton('/content/create/world','World');
        break;

    case 'species':
        $system->createSpecies();
        break;

    case 'world':
        $system->createWorld();
        break;
}
?>

<script src="/js/validation.js"></script>