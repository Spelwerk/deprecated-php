<?php global $form, $sitemap, $component, $person;

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h1('Add Sanity');
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