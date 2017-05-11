<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $background = new Background($sitemap->id);

    $component->title($background->name);

    switch($sitemap->context)
    {
        default:
            $background->view();
            break;

        case 'edit':
            $background->put();
            break;

        case 'attribute':
            require_once('./site/content/background/attribute.php');
            break;

        case 'skill':
            require_once('./site/content/background/skill.php');
            break;
    }
} else {
    $component->title('Background');
    $component->returnButton('/content');
    $system->listBackground();
    $component->h4('Create');
    $component->linkButton('/content/create/background','Create New');
}
?>