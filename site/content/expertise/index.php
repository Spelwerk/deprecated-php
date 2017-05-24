<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Expertise');
        $component->returnButton('/content');
        $system->listExpertise();
        $component->h4('Create');
        $component->linkButton('/content/expertise/create','Create New');
        break;

    case 'create':
        $system->createExpertise();
        break;

    case 'id':
        require_once('./site/content/expertise/id.php');
        break;
}
?>