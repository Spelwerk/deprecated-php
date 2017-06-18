<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $attribute = new Attribute($sitemap->index);

    $component->title($attribute->name);

    switch($sitemap->context)
    {
        default:
            $attribute->view();
            break;

        case 'edit':
            $attribute->put();
            break;
    }
}
?>