<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $weaponGroup = new WeaponGroup($sitemap->index);

    $component->title($weaponGroup->name);

    switch($sitemap->context)
    {
        default:
            $weaponGroup->view();
            break;

        case 'edit':
            $weaponGroup->put();
            break;
    }
}
?>