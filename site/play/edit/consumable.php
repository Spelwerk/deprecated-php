<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:56
 */
global $sitemap, $curl, $form;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$attributeList = $person->getAttribute($person->world->attributeConsumable);
$idList = null;

foreach($attributeList as $attribute) {
    $idList[] = $attribute->id;
}
?>
<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if(!$sitemap->thing): ?>

    <div class="sw-l-content__wrap">
        <h2>Consumable</h2>
        <?php
        foreach($attributeList as $attribute) {
            echo('<a class="sw-c-link" href="/play/'.$sitemap->id.'/'.$sitemap->hash.'/edit/consumable/'.$attribute->id.'">'.$attribute->name.'</a>');
        }
        ?>
    </div>

<?php endif; ?>

<?php if(in_array($sitemap->thing, $idList)): ?>

    <script src="/js/edit_attribute.js"></script>
    <form action="/post.php" method="post">
        <?php
        $attribute = $person->getAttribute(null, $sitemap->thing)[0];

        echo('<h2>'.$attribute->name.'</h2>');

        $form->hidden('return', 'play', 'post');
        $form->hidden('do', 'person--edit--attribute', 'post');
        $form->hidden('id', $person->id, 'post');
        $form->hidden('hash', $person->hash, 'post');

        $form->number(true, 'attribute_id', $attribute->name, $attribute->description, $attribute->id, null, null, $attribute->value);
        ?>
        <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
    </form>

<?php endif; ?>