<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $expertise = new Expertise($sitemap->id);

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