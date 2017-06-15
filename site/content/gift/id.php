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

        case 'attribute':
            require_once('./site/content/gift/attribute.php');
            break;

        case 'skill':
            require_once('./site/content/gift/skill.php');
            break;
    }
}
?>