<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $person = new Person($sitemap->index);

    $component->title($person->nickname);

    switch($sitemap->context)
    {
        default:
            $person->view();
            break;

        case 'cheat':
            require_once('cheat/index.php');
            break;

        case 'edit':
            require_once('edit/index.php');
            break;

        case 'disease':
            require_once('wound/disease.php');
            break;

        case 'sanity':
            require_once('wound/sanity.php');
            break;

        case 'wound':
            require_once('wound/wound.php');
            break;
    }
}
?>