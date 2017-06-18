<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $nature = new Nature($sitemap->index);

    $component->title($nature->name);

    switch($sitemap->context)
    {
        default:
            $nature->view();
            break;

        case 'edit':
            $nature->put();
            break;
    }
}
?>