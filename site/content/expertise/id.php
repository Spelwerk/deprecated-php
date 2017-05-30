<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $expertise = new Expertise($sitemap->index);

    $component->title($expertise->name);

    switch($sitemap->context)
    {
        default:
            $expertise->view();
            break;

        case 'edit':
            $expertise->put();
            break;
    }
}
?>