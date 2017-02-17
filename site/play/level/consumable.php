<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:56
 */
global $sitemap, $curl, $form;
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
            echo('<a class="sw-c-link" href="/play/'.$sitemap->id.'/'.$sitemap->hash.'/level/consumable/'.$attribute->id.'">'.$attribute->name.'</a>');
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

        $form->getNumber('person', 'value', 0, 0, $attribute->maximum, $attribute->value);
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--edit--attribute');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);
        ?>
        <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
    </form>

<?php endif; ?>