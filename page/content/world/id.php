<?php global $component, $form, $sitemap, $user;

require_once('./class/World.php');

if(isset($sitemap->id)) {
    $world = new World($sitemap->id);

    $component->title($world->name);


}
?>

<script src="/js/validation.js"></script>