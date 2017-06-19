<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $person = new Person($sitemap->index);

    $component->title($person->nickname);

    switch($sitemap->context)
    {
        default:
            $person->view();
            break;

        /* Not necessary to have at start
        case 'cheat':
            require_once('cheat/index.php');
            break;
        */

        case 'edit':
            $component->returnButton($person->siteLink);
            require_once('edit/index.php');
            break;

        case 'disease':
            $component->returnButton($person->siteLink);
            $person->postDisease();
            break;

        case 'sanity':
            $component->returnButton($person->siteLink);
            $person->postSanity();
            break;

        case 'wound':
            $component->returnButton($person->siteLink);
            $person->postWound();
            break;
    }
}
?>