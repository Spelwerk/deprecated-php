<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $expertise = new Expertise($sitemap->id);

    $component->title($expertise->name);

    switch($sitemap->context)
    {
        default:
            $expertise->view();
            break;
    }
} else {
    $component->title('Expertise');
    $component->returnButton('/content');
    $system->listExpertise();
    $component->h4('Create');
    $component->linkButton('/content/create/expertise','Create New');
}
?>