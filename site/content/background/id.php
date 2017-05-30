<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $background = new Background($sitemap->index);

    $component->title($background->name);

    switch($sitemap->context)
    {
        default:
            $background->view();
            break;

        case 'edit':
            $background->put();
            break;

        case 'attribute':
            require_once('./site/content/background/attribute.php');
            break;

        case 'skill':
            require_once('./site/content/background/skill.php');
            break;
    }
}
?>