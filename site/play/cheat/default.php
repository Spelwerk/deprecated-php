<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 08:08
 */
global $sitemap, $form;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if($person->isCheater): ?>

    <div class="sw-l-content__wrap">
        <h2>Cheat</h2>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/attribute">Attribute</a>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/characteristic">Characteristic</a>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/expertise">Expertise</a>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/feature">Feature</a>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/milestone">Milestone</a>
        <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/skill">Skill</a>
        <?php if($person->isSupernatural): ?>
            <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat/supernatural">Supernatural</a>
        <?php endif; ?>
    </div>

<?php else: ?>

    <div class="sw-l-content__wrap">
        <h2>Cheat</h2>
        <p>There are options in this place that will change your person into something that is outside of the normal creation structure. Because of this we will remove your person from all public lists if you choose to move forward and cheat.</p>
        <form action="/post.php" method="post">
            <?php
            $form->getHidden('post', 'return', 'play');
            $form->getHidden('post', 'returnafter', 'cheat');
            $form->getHidden('post', 'do', 'person--put');
            $form->getHidden('post', 'id', $person->id);
            $form->getHidden('post', 'hash', $person->hash);
            $form->getHidden('person', 'cheated', 1);
            ?>
            <input class="sw-c-link sw-c-link--dangerous" type="submit" value="Cheat"/>
        </form>
    </div>

<?php endif; ?>

