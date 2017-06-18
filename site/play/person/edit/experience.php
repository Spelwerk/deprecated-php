<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $attribute = $person->getAttribute(null, $person->world->experienceAttribute)[0];

    $component->h2($attribute->name);
    $component->wrapStart();
    $form->form([
        'do' => 'relation--value--post',
        'context' => 'person',
        'id' => $person->id,
        'context2' => 'attribute',
        'return' => 'play/person'
    ]);
    $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);

    $form->submit();
    $component->wrapEnd();
}
?>