<?php global $component, $sitemap, $system;

if($sitemap->id) {
    $person = new Person($sitemap->id, $sitemap->secret);

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
            require_once('./site/content/person/disease.php');
            break;

        case 'sanity':
            require_once('./site/content/person/sanity.php');
            break;

        case 'wound':
            require_once('./site/content/person/wound.php');
            break;
    }
}
?>