<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:56
 */
global $sitemap, $curl, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$attributeList = $person->getAttribute($person->world->consumableAttributeType);
$idList = null;

foreach($attributeList as $attribute) {
    $idList[] = $attribute->id;
}

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    if($sitemap->context && in_array($sitemap->context, $idList)) {
        $attribute = $person->getAttribute(null, $sitemap->context)[0];

        $component->h2($attribute->name);
        $component->wrapStart();
        $form->formStart([
            'do' => 'person--attribute',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
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

<script src="/js/validation.js"></script>
