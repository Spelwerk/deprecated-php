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
            require_once('./site/content/person/cheat/index.php');
            break;

        case 'edit':
            require_once('./site/content/person/edit/index.php');
            break;

        case 'disease':
            require_once('./site/content/person/wound/disease.php');
            break;

        case 'sanity':
            require_once('./site/content/person/wound/sanity.php');
            break;

        case 'wound':
            require_once('./site/content/person/wound/wound.php');
            break;
    }
}
?>