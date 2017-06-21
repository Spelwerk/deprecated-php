<?php global $component, $sitemap, $system, $user;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Software');
    $system->createSoftware();
} else {
    $component->title('Software');
    $component->returnButton('/content');

    if($user->isActive) $component->linkButton('/content/software/create','Create New',false,'sw-is-green');

    $system->listSoftware();
}
?>