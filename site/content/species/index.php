<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $species = new Species($sitemap->id);

    $component->title($species->name);

    switch($sitemap->context)
    {
        default:
            $species->view();
            break;

        case 'edit':
            $species->put();
            break;

        case 'attribute':
            require_once('./site/content/species/attribute.php');
            break;

        case 'background':
            require_once('./site/content/species/background.php');
            break;

        case 'expertise':
            require_once('./site/content/species/expertise.php');
            break;

        case 'gift':
            require_once('./site/content/species/gift.php');
            break;

        case 'imperfection':
            require_once('./site/content/species/imperfection.php');
            break;

        case 'milestone':
            require_once('./site/content/species/milestone.php');
            break;

        case 'skill':
            require_once('./site/content/species/skill.php');
            break;
    }
} else {
    $component->title('Species');
    $component->returnButton('/content');
    $system->listSpecies();
    $component->h4('Create');
    $component->linkButton('/content/create/species','Create New');
}
?>