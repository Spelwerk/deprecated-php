<?php global $component, $sitemap, $system;

$index = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

if(is_int($index)) {
    require_once('id.php');
} else {
    $component->title('Doctrine');
    $component->returnButton('/content');
    $component->subtitle('You cannot create new doctrine from here. If you wish to do so: go to manifestation');

    $system->listDoctrine();

    $component->link('/content/manifestation','Go to manifestation');
}
?>