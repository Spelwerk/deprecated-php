<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->index) {
    $bionic = new Bionic($sitemap->index);

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
}
?>