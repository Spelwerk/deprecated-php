<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $software = new Software($sitemap->index);

    $component->title($software->name);

    switch($sitemap->context)
    {
        default:
            $software->view();
            break;

        case 'edit':
            $software->put();
            break;
    }
}
?>