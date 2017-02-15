<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:56
 */
global $sitemap, $form;
$person = new Person($sitemap->id, $sitemap->hash);
?>

<script src="/js/edit_attribute.js"></script>
<h2>Experience</h2>
<form action="/post.php" method="post">
    <?php
    $attribute = $person->getAttribute(null, $person->world->experience)[0];

    $form->getNumber('person', 'value', 0, 0, 999, $attribute->value);
    $form->getHidden('post', 'return', 'play');
    $form->getHidden('post', 'do', 'person--experience');
    $form->getHidden('post', 'id', $person->id);
    $form->getHidden('post', 'hash', $person->hash);
    ?>
    <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
</form>
