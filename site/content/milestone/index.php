<?php global $component, $sitemap, $system, $user;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Milestone');
    $system->createMilestone();
} else {
    $component->title('Milestone');
    $component->returnButton('/content');

    if($user->isActive) $component->linkButton('/content/milestone/create','Create New',false,'sw-is-green');

    $system->listMilestone();
}
?>