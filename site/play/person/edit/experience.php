<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $attribute = $person->getAttribute(null, $person->world->experienceAttribute)[0];

    $component->h2($attribute->name);
    $component->wrapStart();
    $form->form([
        'do' => 'person--attribute',
        'context' => 'person',
        'context2' => 'attribute',
        'return' => 'play/person',
        'id' => $person->id
    ]);
    $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, null, $attribute->value);

    $form->submit();
    $component->wrapEnd();
}
?>