<?php global $component, $sitemap;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('./site/user/id.php');
} else {
    $component->title('User');

    if(!$user->id) {
        $component->linkButton('/user/login','Login');
        $component->linkButton('/user/create','Create New');
    }
}
?>