<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:46
 */
global $sitemap;
$person = new Person($sitemap->id, $sitemap->hash);
?>
<div class="sw-l-content__wrap">
    <h2>Level Up</h2>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/asset">***Asset</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/bionic">***Bionic</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/experience">Experience</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/expertise">Expertise</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/protection">***Protection</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/skill">Skill</a>
    <a class="sw-c-link" href="/play/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/level/weapon">Weapon</a>
    <?php if($person->isSupernatural) echo('<a class="sw-c-link" href="/play/'.$sitemap->id.'/'.$sitemap->hash.'/cheat/supernatural">Supernatural</a>'); ?>
</div>