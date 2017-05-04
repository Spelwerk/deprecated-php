<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Cheat '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h2('Doctrine');
    $person->postDoctrine(true);
}
?>

<script src="/js/validation.js"></script>
