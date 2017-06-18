<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $focus = new Focus($sitemap->index);

    $component->title($focus->name);

    switch($sitemap->context)
    {
        default:
            $focus->view();
            break;

        case 'edit':
            $focus->put();
            break;
    }
}
?>