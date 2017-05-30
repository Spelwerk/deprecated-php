<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $imperfection = new Imperfection($sitemap->index);

    $component->title($imperfection->name);

    switch($sitemap->context)
    {
        default:
            $imperfection->view();
            break;

        case 'edit':
            $imperfection->put();
            break;
    }
}
?>