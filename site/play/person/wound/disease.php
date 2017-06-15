<?php global $form, $sitemap, $component, $person;

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h1('Add Disease');
    $component->wrapStart();
    $form->form([
        'do' => 'context--post',
        'context' => 'person',
        'id' => $person->id,
        'context2' => 'disease',
        'return' => 'play/person',
        'returnid' => 'disease'
    ]);
    $form->varchar(true, 'name', 'Short Description', 'A disease is a persistant harmful effect that you have suffered. It can either be poison or natural sickness. You are either way probably debilitated.');
    $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
    $form->submit();
    $component->wrapEnd();
}
?>