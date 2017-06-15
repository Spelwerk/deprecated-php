<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $milestone = new Milestone($sitemap->index);

    $component->title($milestone->name);

    switch($sitemap->context)
    {
        default:
            $milestone->view();
            break;

        case 'edit':
            $milestone->put();
            break;

        case 'attribute':
            require_once('./site/content/milestone/attribute.php');
            break;

        case 'skill':
            require_once('./site/content/milestone/skill.php');
            break;
    }
}
?>