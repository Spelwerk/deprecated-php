<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Cheat '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php if($sitemap->unique): ?>

        <?php
        $attribute = $person->getAttribute(null, $sitemap->unique)[0];

        $component->h2($attribute->name);
        $component->wrapStart();
        $form->formStart([
            'do' => 'person--attribute',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);
        $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->formEnd();
        $component->wrapEnd();
        ?>

        <script src="/js/validation.js"></script>

    <?php else: ?>

        <?php
        $component->wrapStart();
        $component->h2('Attribute');
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
        ?>

    <?php endif; ?>

<?php endif; ?>