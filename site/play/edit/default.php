<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:46
 */
global $sitemap;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<div class="sw-l-content__wrap">
    <h2>Edit</h2>
    <?php /*<a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/asset">Asset</a> */?>
    <?php if($person->world->existsBionic): ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/bionic">Bionic</a>
    <?php endif; ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/consumable">Consumable</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/description">Description</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/experience">Experience</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/expertise">Expertise</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/protection">Protection</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/skill">Skill</a>
    <?php if($person->isSupernatural): ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/supernatural">Supernatural</a>
    <?php endif; ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/edit/weapon">Weapon</a>
    <a class="sw-c-link sw-c-link--dangerous" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/cheat">Cheat</a>
</div>