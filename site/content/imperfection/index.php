<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Imperfection');
        $component->returnButton('/content');
        $system->listImperfection();
        $component->h4('Create');
        $component->linkButton('/content/imperfection/create','Create New');
        break;

    case 'create':
        $system->createImperfection();
        break;

    case 'id':
        require_once('./site/content/imperfection/id.php');
        break;
}
?>