<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
 */
global $sitemap, $form;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if($sitemap->unique): ?>

    <script src="/js/edit_attribute.js"></script>

    <form action="/post.php" method="post">
    <?php
    $attribute = $person->getAttribute(null, $sitemap->unique)[0];

    echo('<h2>'.$attribute->name.'</h2>');

    $form->hidden('return', 'play', 'post');
    $form->hidden('do', 'person--edit--attribute', 'post');
    $form->hidden('id', $person->id, 'post');
    $form->hidden('hash', $person->hash, 'post');

    $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
    ?>
    <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
    </form>

<?php else: ?>

    <div class="sw-l-content__wrap">
        <h2>Attribute</h2>

        <h3>Body</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeBody) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Combat</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeCombat) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Consumable</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeConsumable) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Damage</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeDamage) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Experience</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeExperience) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <?php if($person->isSupernatural): ?>

            <h3>Power</h3>
            <?php
            foreach($person->getAttribute($person->world->attributePower) as $object) {
                echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
            }
            ?>

        <?php endif; ?>

        <h3>Protection</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeProtection) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Reputation</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeReputation) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

        <h3>Wound</h3>
        <?php
        foreach($person->getAttribute($person->world->attributeWound) as $object) {
            echo('<a class="sw-c-link" href="/play/'.$person->id.'/'.$person->hash.'/cheat/attribute/'.$object->id.'">'.$object->name.'</a>');
        }
        ?>

    </div>

<?php endif; ?>