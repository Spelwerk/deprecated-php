<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $weapon = new Weapon($sitemap->index);

    $component->title($weapon->name);

    switch($sitemap->context)
    {
        default:
            $weapon->view();
            break;

        case 'edit':
            $weapon->put();
            break;
    }
}
?>