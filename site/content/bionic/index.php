<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $bionic = new Bionic($sitemap->id);

    $component->title($bionic->name);

    switch($sitemap->context)
    {
        default:
            $bionic->view();
            break;

        case 'edit':
            $bionic->put();
            break;

        case 'attribute':
            require_once('./site/content/bionic/attribute.php');
            break;

        case 'augmentation':
            require_once('./site/content/bionic/augmentation.php');
            break;
    }
} else {
    $component->title('Bionic');
    $component->returnButton('/content');
    $system->listBionic();
    $component->h4('Create');
    $component->linkButton('/content/create/bionic','Create New');
}
?>