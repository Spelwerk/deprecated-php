<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 19:15
 */
global $form, $sitemap, $component, $person;

require_once('./class/Person.php');
$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Add Sanity');

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->wrapStart();
    $form->formStart([
        'do' => 'person--wound',
        'id' => $person->id,
        'secret' => $person->secret,
        'return' => 'play/person/id',
        'returnid' => 'sanity',
        'context' => 'sanity'
    ]);
    $form->varchar(true, 'name', 'Short Description', 'Taking sanity damage is no easy thing. Every mind can only take so much pressure before breaking.');
    $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
    $form->formEnd();
    $component->wrapEnd();
}
?>

<script src="/js/validation.js"></script>
