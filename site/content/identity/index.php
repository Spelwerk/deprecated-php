<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else {
    $component->title('Identity');
    $component->returnButton('/content');
    $component->subtitle('You cannot create new identities.');

    $system->listIdentity();
}
?>