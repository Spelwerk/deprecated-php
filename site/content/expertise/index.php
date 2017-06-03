<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/expertise/id.php');
} else if($index == 'create') {
    $component->title('Expertise');
    $system->createExpertise();
} else {
    $component->title('Expertise');
    $component->returnButton('/content');
    $system->listExpertise();
    $component->linkButton('/content/expertise/create','Create New',false,'sw-is-green');
}
?>