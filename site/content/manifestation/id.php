<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $manifestation = new Manifestation($sitemap->id);

    $component->title($manifestation->name);

    switch($sitemap->context)
    {
        default:
            $manifestation->view();
            break;

        case 'edit':
            $manifestation->put();
            break;

        case 'background':
            require_once('./site/content/manifestation/background.php');
            break;

        case 'doctrine':
            require_once('./site/content/manifestation/doctrine.php');
            break;

        case 'focus':
            require_once('./site/content/manifestation/focus.php');
            break;

        case 'gift':
            require_once('./site/content/manifestation/gift.php');
            break;

        case 'imperfection':
            require_once('./site/content/manifestation/imperfection.php');
            break;

        case 'milestone':
            require_once('./site/content/manifestation/milestone.php');
            break;
    }
}
?>