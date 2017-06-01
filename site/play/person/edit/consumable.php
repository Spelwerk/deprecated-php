<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $attributeList = $person->getAttribute($person->world->consumableAttributeType);
    $idList = null;

    foreach($attributeList as $attribute) {
        $idList[] = $attribute->id;
    }

    if($sitemap->extra2 && in_array($sitemap->extra2, $idList)) {
        $attribute = $person->getAttribute(null, $sitemap->extra2)[0];

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
    } else {
        $component->h2('Consumable');
        $component->wrapStart();
        foreach($attributeList as $attribute) {
            $component->linkButton($person->siteLink.'/edit/consumable/'.$attribute->id,$attribute->name);
        }
        $component->wrapEnd();
    }
}
?>