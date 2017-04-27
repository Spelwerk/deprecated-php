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
?>

<?php if($person->isOwner): ?>

    <?php
    $component->returnButton($person->siteLink);
    $component->wrapStart();
    $component->h2('Add Bionic');
    $component->p('Once attached. Bionics cannot be removed.');
    $component->wrapEnd();

    $person->postBionic();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>