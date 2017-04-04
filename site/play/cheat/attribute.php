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

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php if($sitemap->unique): ?>

    <?php
    $attribute = $person->getAttribute(null, $sitemap->unique)[0];

    $component->h2($attribute->name);
    $component->wrapStart();
    $form->formStart();
    $form->hidden('return', 'play', 'post');
    $form->hidden('do', 'person--edit--attribute', 'post');
    $form->hidden('id', $person->id, 'post');
    $form->hidden('hash', $person->hash, 'post');
    $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/play_create.js"></script>

<?php else: ?>

    <?php
    $component->wrapStart();
    $component->h2('Attribute');
    $component->h3('Body');

    foreach($person->getAttribute($person->world->attributeBody) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->h3('Combat');

    foreach($person->getAttribute($person->world->attributeCombat) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->h3('Consumable');

    foreach($person->getAttribute($person->world->attributeConsumable) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->h3('Damage');

    foreach($person->getAttribute($person->world->attributeDamage) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    if($person->isSupernatural) {
        $component->h3('Power');

        foreach($person->getAttribute($person->world->attributePower) as $object) {
            $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
        }
    }

    $component->h3('Protection');

    foreach($person->getAttribute($person->world->attributeProtection) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->h3('Reputation');

    foreach($person->getAttribute($person->world->attributeReputation) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->h3('Wound');

    foreach($person->getAttribute($person->world->attributeWound) as $object) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id,$object->name);
    }

    $component->wrapEnd();
    ?>

<?php endif; ?>