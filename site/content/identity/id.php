<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $identity = new Identity($sitemap->index);

    $component->title($identity->name);

    switch($sitemap->context)
    {
        default:
            $identity->view();
            break;

        case 'edit':
            $identity->put();
            break;
    }
}
?>