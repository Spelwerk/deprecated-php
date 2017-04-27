<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-26
 * Time: 16:18
 */
global $sitemap, $user, $form, $component, $curl;

require_once('./class/World.php');

if(isset($sitemap->id)) {
    $world = new World($sitemap->id);

    $component->title($world->name);
    $component->returnButton($world->siteLink);

    $world->postAttribute();
}
?>

<script src="/js/validation.js"></script>
<script src="/js/play.js"></script>