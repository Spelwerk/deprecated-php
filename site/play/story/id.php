<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $story = new Story($sitemap->index, $sitemap->secret);

    $component->title($story->name);

    switch($sitemap->context)
    {
        default:
            $story->view();
            break;

        case 'edit':
            $story->put();
            break;

        case 'location':
            require_once('./site/content/story/location.php');
            break;

        case 'meeting':
            require_once('./site/content/story/meeting.php');
            break;

        case 'person':
            require_once('./site/content/story/person.php');
            break;
    }
}
?>