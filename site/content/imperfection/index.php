<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $imperfection = new Imperfection($sitemap->id);

    $component->title($imperfection->name);

    switch($sitemap->context)
    {
        default:
            $imperfection->view();
            break;
    }
} else {
    $component->title('Imperfection');
    $component->returnButton('/content');
    $system->listImperfection();
    $component->h4('Create');
    $component->linkButton('/content/create/imperfection','Create New');
}
?>