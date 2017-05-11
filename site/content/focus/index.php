<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $focus = new Focus($sitemap->id);

    $component->title($focus->name);

    switch($sitemap->context)
    {
        default:
            $focus->view();
            break;

        case 'edit':
            $focus->put();
            break;
    }
} else {
    $component->title('Focus');
    $component->returnButton('/content');
    $system->listFocus();
    $component->h4('Create');
    $component->linkButton('/content/create/focus','Create New');
}
?>