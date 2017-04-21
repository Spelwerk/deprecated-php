<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:56
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $attribute = $person->getAttribute(null, $person->world->experience)[0];

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
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>