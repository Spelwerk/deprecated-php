<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $milestone = new Milestone($sitemap->id);

    $component->title($milestone->name);

    switch($sitemap->context)
    {
        default:
            $milestone->view();
            break;

        case 'edit':
            $milestone->put();
            break;
    }
} else {
    $component->title('Milestone');
    $component->returnButton('/content');
    $system->listMilestone();
    $component->h4('Create');
    $component->linkButton('/content/create/milestone','Create New');
}
?>