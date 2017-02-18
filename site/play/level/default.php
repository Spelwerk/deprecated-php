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
    <h2>Level Up</h2>
    <?php /*<a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/asset">Asset</a> */?>
    <?php if($person->world->existsBionic): ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/bionic">Bionic</a>
    <?php endif; ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/consumable">Consumable</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/experience">Experience</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/expertise">Expertise</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/protection">Protection</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/skill">Skill</a>
    <?php if($person->isSupernatural): ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/supernatural">Supernatural</a>
    <?php endif; ?>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/weapon">Weapon</a>
</div>