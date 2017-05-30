<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $attribute = $person->getAttribute(null, $person->world->experienceAttribute)[0];

    $component->h2($attribute->name);
    $component->wrapStart();
    $form->formStart([
        'do' => 'person--attribute',
        'context' => 'person',
        'context2' => 'attribute',
        'return' => 'play/person',
        'id' => $person->id,
        'secret' => $person->secret
    ]);
    $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, null, $attribute->value);

    $form->formEnd();
    $component->wrapEnd();
}
?>