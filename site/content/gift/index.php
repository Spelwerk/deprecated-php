<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $gift = new Gift($sitemap->id);

    $component->title($gift->name);

    switch($sitemap->context)
    {
        default:
            $gift->view();
            break;

        case 'edit':
            $gift->put();
            break;
    }
} else {
    $component->title('Gift');
    $component->returnButton('/content');
    $system->listGift();
    $component->h4('Create');
    $component->linkButton('/content/create/gift','Create New');
}
?>