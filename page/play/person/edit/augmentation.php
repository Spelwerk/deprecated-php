<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 12:51
 */
global $sitemap, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    $component->h2('Augmentation');
    $component->subtitle('Once attached. Augmentations cannot be removed.');

    if($sitemap->context == 'add') {
        $person->postAugmentation($sitemap->context);
    } else {
        $bionicList = $person->getBionic();

        $component->wrapStart();

        foreach($bionicList as $bionic) {
            $component->linkButton($person->siteLink.'/edit/augmentation/'.$bionic->id,$bionic->name);
        }

        $component->wrapEnd();
    }
}
?>

<script src="/js/validation.js"></script>
