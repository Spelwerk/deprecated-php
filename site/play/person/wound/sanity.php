<?php global $form, $sitemap, $component, $person;

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h1('Add Sanity');
    $component->wrapStart();
    $form->form([
        'do' => 'person--wound',
        'id' => $person->id,
        'return' => 'play/person',
        'returnid' => 'sanity',
        'context' => 'sanity'
    ]);
    $form->varchar(true, 'name', 'Short Description', 'Taking sanity damage is no easy thing. Every mind can only take so much pressure before breaking.');
    $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
    $form->submit();
    $component->wrapEnd();
}
?>