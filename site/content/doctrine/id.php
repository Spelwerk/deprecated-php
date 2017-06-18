<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $doctrine = new Doctrine($sitemap->index);

    $component->title($doctrine->name);

    switch($sitemap->context)
    {
        default:
            $doctrine->view();
            break;

        case 'edit':
            $doctrine->put();
            break;
    }
}
?>