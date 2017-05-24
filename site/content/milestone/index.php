<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Milestone');
        $component->returnButton('/content');
        $system->listMilestone();
        $component->h4('Create');
        $component->linkButton('/content/milestone/create','Create New');
        break;

    case 'create':
        $system->createMilestone();
        break;

    case 'id':
        require_once('./site/content/milestone/id.php');
        break;
}
?>