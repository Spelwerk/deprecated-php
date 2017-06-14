<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/protection/id.php');
} else if($index == 'create') {
    $component->title('Protection');
    $system->createProtection();
} else {
    $component->title('Protection');
    $component->returnButton('/content');
    $system->listProtection();
    $component->linkButton('/content/protection/create','Create New',false,'sw-is-green');
}
?>