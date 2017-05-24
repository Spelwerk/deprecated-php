<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $gift = new Gift($sitemap->id);

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