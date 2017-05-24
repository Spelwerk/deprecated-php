<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $milestone = new Milestone($sitemap->id);

    $component->title($milestone->name);

    switch($sitemap->context)
    {
        default:
            $milestone->view();
            break;

        case 'edit':
            $milestone->put();
            break;
    }
}
?>