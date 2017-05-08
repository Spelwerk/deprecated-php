<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $species = new Species($sitemap->id);

    $component->title($species->name);

    switch($sitemap->context)
    {
        default:
            $species->view();
            break;

        case 'attribute':
            require_once('./site/content/species/attribute.php');
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