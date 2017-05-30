<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/content/skill/id.php');
} else if($index == 'create') {
    $system->createSkill();
} else {
    $component->title('Skill');
    $component->returnButton('/content');
    $system->listSkill();
    $component->h4('Create');
    $component->linkButton('/content/skill/create','Create New');
}
?>