<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $world = new World($sitemap->index);

    $component->title($world->name);

    switch($sitemap->context)
    {
        default:
            $world->view();
            break;

        case 'edit':
            $world->put();
            break;

        case 'attribute':
            require_once('./site/content/world/attribute.php');
            break;

        case 'background':
            require_once('./site/content/world/background.php');
            break;

        case 'bionic':
            require_once('./site/content/world/bionic.php');
            break;

        case 'expertise':
            require_once('./site/content/world/expertise.php');
            break;

        case 'gift':
            require_once('./site/content/world/gift.php');
            break;

        case 'imperfection':
            require_once('./site/content/world/imperfection.php');
            break;

        case 'manifestation':
            require_once('./site/content/world/manifestation.php');
            break;

        case 'milestone':
            require_once('./site/content/world/milestone.php');
            break;

        case 'protection':
            require_once('./site/content/world/protection.php');
            break;

        case 'skill':
            require_once('./site/content/world/skill.php');
            break;

        case 'software':
            require_once('./site/content/world/software.php');
            break;

        case 'species':
            require_once('./site/content/world/species.php');
            break;

        case 'weapon':
            require_once('./site/content/world/weapon.php');
            break;
    }
}
?>