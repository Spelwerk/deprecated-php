<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/imperfection/id.php');
} else if($index == 'create') {
    $component->title('Imperfection');
    $system->createImperfection();
} else {
    $component->title('Imperfection');
    $component->returnButton('/content');
    $system->listImperfection();
    $component->linkButton('/content/imperfection/create','Create New',false,'sw-is-green');
}
?>