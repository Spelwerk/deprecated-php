<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 09:58
 */
global $sitemap;

require_once('./class/World.php');

$world = null;
$userOwner = null;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $world = new World($sitemap->id, $sitemap->hash);
} else if (isset($sitemap->id)) {
    $world = new World($sitemap->id);
}

if(isset($user)) {
    $list = $user->getWorld();

    if($list) {
        foreach($list as $p) {
            if($sitemap->id == $p['world_id'] && $sitemap->hash == $p['world_hash']) {
                $userOwner = true;
            }
        }
    }
}

?>

<?php if(!isset($world) || !$world->isCalculated): ?>

    <?php
    require_once('./class/System.php');
    $system = new System();
    $system->createWorld($world);
    ?>

<?php endif; ?>

<?php if($world && $world->isCalculated): ?>

    <?php if($world->isOwner && isset($user) && $userOwner != true): ?>

        <form action="/post.php" method="post">
            <input type="hidden" name="post--return" value="play"/>
            <input type="hidden" name="post--do" value="user--save"/>
            <input type="hidden" name="post--id" value="<?php echo $world->id; ?>"/>
            <input type="hidden" name="post--hash" value="<?php echo $world->hash; ?>"/>
            <input type="hidden" name="post--user" value="<?php echo $user->id; ?>"/>
            <input class="sw-c-link sw-c-link--friendly sw-js-submit" type="submit" value="Save This World"/>
        </form>

    <?php endif; ?>

    <h2 class="sw-js-world-name"><?php echo($world->name) ?></h2>

    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/values">Edit Values</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/species">Edit species</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/caste">Edit caste</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/nature">Edit nature</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/identity">Edit identity</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/defaults">Edit defaults</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/skill">Edit skills</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/expertise">Edit expertise</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/characteristic">Edit characteristics</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/milestones">Edit milestones</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/weapon">Edit weapons</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/protection">Edit protection</a>

        <?php if($world->existsSupernatural): ?>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/manifestation">Edit manifestation</a>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/focus">Edit focus</a>
        <?php endif; ?>

        <?php if($world->existsBionic): ?>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/bionic">Edit bionic</a>
        <?php endif; ?>

        <?php if($world->existsAugmentation): ?>
        <a class="sw-c-link" href="/world/<?php echo $sitemap->id; ?>/<?php echo $sitemap->hash; ?>/augmentation">Edit augmentation</a>
        <?php endif; ?>
    </div>

<?php endif; ?>

<script src="/js/validation.js"></script>
<script>
    document.title = "Spelwerk: " + $(".sw-js-world-name").text();
</script>