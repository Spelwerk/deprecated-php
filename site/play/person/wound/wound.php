<?php global $form, $sitemap, $component, $person;

if($person->isOwner) {
    $component->returnButton($person->siteLink);
    $component->h1('Add Wound');
    $component->wrapStart();
    $form->form([
        'do' => 'context--post',
        'context' => 'person',
        'id' => $person->id,
        'context2' => 'wound',
        'return' => 'play/person',
        'returnid' => 'wound'
    ]);
    $form->varchar(true, 'name', 'Short Description', 'A wound is significant damage that you have taken. It can either be serious or lethal.');
    $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
    $form->submit();
    $component->wrapEnd();
}
?>