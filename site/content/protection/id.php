<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $protection = new Protection($sitemap->index);

    $component->title($protection->name);

    switch($sitemap->context)
    {
        default:
            $protection->view();
            break;

        case 'edit':
            $protection->put();
            break;
    }
}
?>