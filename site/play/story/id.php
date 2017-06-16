<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $story = new Story($sitemap->index);

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
            require_once('location.php');
            break;

        case 'meeting':
            require_once('meeting.php');
            break;

        case 'person':
            require_once('person.php');
            break;
    }
}
?>