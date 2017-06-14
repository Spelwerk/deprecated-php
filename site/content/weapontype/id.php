<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $weaponType = new WeaponType($sitemap->index);

    $component->title($weaponType->name);

    switch($sitemap->context)
    {
        default:
            $weaponType->view();
            break;

        case 'edit':
            $weaponType->put();
            break;
    }
}
?>