<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Skill');
        $component->returnButton('/content');
        $system->listSkill();
        $component->h4('Create');
        $component->linkButton('/content/skill/create','Create New');
        break;

    case 'create':
        $system->createSkill();
        break;

    case 'id':
        require_once('./site/content/skill/id.php');
        break;
}
?>