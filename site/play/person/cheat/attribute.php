<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    if(is_int($sitemap->extra2)) {
        $attribute = $person->getAttribute(null, $sitemap->extra2)[0];

        $component->h2($attribute->name);
        $component->wrapStart();
        $form->formStart([
            'do' => 'person--attribute',
            'context' => 'person',
            'context2' => 'attribute',
            'return' => 'play/person',
            'id' => $person->id
        ]);
        $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->formEnd();
        $component->wrapEnd();
    } else {
        $component->h2('Attribute');

        $component->wrapStart();
        $component->h3('Body');

        foreach($person->getAttribute($person->world->bodyAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->h3('Combat');

        foreach($person->getAttribute($person->world->combatAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->h3('Consumable');

        foreach($person->getAttribute($person->world->consumableAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->h3('Damage');

        foreach($person->getAttribute($person->world->damageAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        if($person->isSupernatural) {
            $component->h3('Power');

            foreach($person->getAttribute($person->manifestation->powerAttribute) as $object) {
                $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
            }
        }

        $component->h3('Protection');

        foreach($person->getAttribute($person->world->protectionAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->h3('Reputation');

        foreach($person->getAttribute($person->world->reputationAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->h3('Wound');

        foreach($person->getAttribute($person->world->woundAttributeType) as $object) {
            $component->linkButton($person->siteLink.'/cheat/attribute/'.$object->id, $object->name);
        }

        $component->wrapEnd();
    }
}
?>