<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $species = new Species($sitemap->index);

    $component->title($species->name);

    switch($sitemap->context)
    {
        default:
            $species->view();
            break;

        case 'edit':
            $species->put();
            break;

        case 'attribute':
            require_once('./site/content/species/attribute.php');
            break;

        case 'background':
            require_once('./site/content/species/background.php');
            break;

        case 'expertise':
            require_once('./site/content/species/expertise.php');
            break;

        case 'gift':
            require_once('./site/content/species/gift.php');
            break;

        case 'imperfection':
            require_once('./site/content/species/imperfection.php');
            break;

        case 'milestone':
            require_once('./site/content/species/milestone.php');
            break;

        case 'skill':
            require_once('./site/content/species/skill.php');
            break;
    }
}
?>