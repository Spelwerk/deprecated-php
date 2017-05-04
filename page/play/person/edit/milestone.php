<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 29/03/2017
 * Time: 14:24
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    $component->h2('Milestone');

    $list = $person->getMilestone();

    $component->wrapStart();

    if(isset($list)) {
        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'weapon');
        }
    }

    $component->wrapEnd();
}
?>

<script src="/js/validation.js"></script>
