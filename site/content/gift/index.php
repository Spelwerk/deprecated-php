<?php global $component, $sitemap, $system;

switch($sitemap->index) {
    default:
        $component->title('Gift');
        $component->returnButton('/content');
        $system->listGift();
        $component->h4('Create');
        $component->linkButton('/content/gift/create','Create New');
        break;

    case 'create':
        $system->createGift();
        break;

    case 'id':
        require_once('./site/content/gift/id.php');
        break;
}
?>