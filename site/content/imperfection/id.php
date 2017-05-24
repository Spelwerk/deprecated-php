<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $imperfection = new Imperfection($sitemap->id);

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