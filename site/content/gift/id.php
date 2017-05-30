<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $gift = new Gift($sitemap->index);

    $component->title($gift->name);

    switch($sitemap->context)
    {
        default:
            $gift->view();
            break;

        case 'edit':
            $gift->put();
            break;
    }
}
?>