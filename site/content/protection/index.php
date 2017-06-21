<?php global $component, $sitemap, $system, $user;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Protection');
    $system->createProtection();
} else {
    $component->title('Protection');
    $component->returnButton('/content');

    if($user->isActive) $component->linkButton('/content/protection/create','Create New',false,'sw-is-green');

    $system->listProtection();
}
?>