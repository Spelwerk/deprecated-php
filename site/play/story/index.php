<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/play/story/id.php');
} else if($index == 'create') {
    $component->title('Create Story');

    $world = isset($_POST['item--world_id']) ? new World($_POST['item--world_id']) : null;

    $system->createStory($world);
} else {
    $component->title('Story');
    $component->returnButton('/play');
    $system->listStory();
    $component->h4('Create');
    $component->linkAction('/play/story/create','Create Story','A story, or a character, is what you use to play the game.','/img/link-story-w.png');
}
?>