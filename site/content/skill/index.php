<?php global $component, $sitemap, $system, $user;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else if($index == 'create') {
    $component->title('Skill');
    $system->createSkill();
} else {
    $component->title('Skill');
    $component->returnButton('/content');

    if($user->isActive) $component->linkButton('/content/skill/create','Create New',false,'sw-is-green');

    $system->listSkill();
}
?>