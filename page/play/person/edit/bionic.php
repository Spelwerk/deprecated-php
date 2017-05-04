<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
 */
global $sitemap, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h2('Bionic');
    $component->subtitle('Once attached. Bionics cannot be removed.');

    $person->postBionic();
}
?>

<script src="/js/validation.js"></script>
