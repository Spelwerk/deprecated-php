<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 10:55
 */
global $sitemap, $user;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = null;
$userOwner = null;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $person = new Person($sitemap->id, $sitemap->hash);
} else if (isset($sitemap->id)) {
    $person = new Person($sitemap->id);
}

$world = isset($_POST['person--world_id'])
    ? new World($_POST['person--world_id'])
    : null;

$species = isset($_POST['person--species_id'])
    ? new Species($_POST['person--species_id'])
    : null;

if(isset($user)) {
    $list = $user->getPerson();

    if($list) {
        foreach($list as $p) {
            if($sitemap->id == $p['person_id'] && $sitemap->hash == $p['person_hash']) {
                $userOwner = true;
            }
        }
    }
}
?>

<script src="/js/play.js"></script>

<?php if(!isset($person) || !$person->isCalculated): ?>

    <?php
    $system = new System();
    $system->createPerson($person, $world, $species);
    ?>

<?php endif; ?>



<?php if($person && $person->isCalculated): ?>

    <?php if($person->isOwner): ?>

        <div class="sw-l-quicklink">
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level"><img src="/img/arrow-up.png"/></a>
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/wound"><img src="/img/wound.png"/></a>
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/weapon"><img src="/img/weapon.png"/></a>
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/protection"><img src="/img/armor.png"/></a>
            <?php if($person->world->existsBionic): ?>
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/bionic"><img src="/img/bionic.png"/></a>
            <?php endif; ?>
            <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/edit.png"/></a>
        </div>

        <?php if(isset($user) && $userOwner != true): ?>

            <form action="/post.php" method="post">
                <input type="hidden" name="post--return" value="play"/>
                <input type="hidden" name="post--do" value="user--save"/>
                <input type="hidden" name="post--id" value="<?php echo $person->id; ?>"/>
                <input type="hidden" name="post--hash" value="<?php echo $person->hash; ?>"/>
                <input type="hidden" name="post--user" value="<?php echo $user->id; ?>"/>
                <input class="sw-c-link sw-c-link--friendly sw-js-submit" type="submit" value="Save This Person"/>
            </form>

        <?php endif; ?>

    <?php endif; ?>

    <h2 class="sw-js-person-name"><?php echo($person->firstname.' '.$person->surname); ?></h2>

    <?php echo(
        '<div class="sw-l-content__wrap">'.
        '<p>Nickname: '.$person->nickname.'</p>'.
        '<p>Age: '.$person->age.'</p>'.
        '<p>Gender: '.$person->gender.'</p>'.
        '<p>Occupation: '.$person->occupation.'</p>'.
        '</div>'
    ); ?>

    <h2>Skill</h2>
    <?php
    $person->makeButton($person->getAttribute($person->world->attributeSkill), 'skill');
    $person->makeExpertise();
    $person->makeSupernatural();
    ?>

    <h2>Attribute</h2>
    <?php
    $person->makeButton($person->getAttribute($person->world->attributeReputation), 'skill');
    $person->makeButton($person->getAttribute($person->world->attributeCombat), 'skill');
    ?>

    <h2>Consumable</h2>
    <?php $person->makeButton($person->getAttribute($person->world->attributeConsumable), 'consumable'); ?>

    <h2 id="weapon">Weapon</h2>
    <?php $person->makeButton($person->getWeapon(1), 'weapon'); ?>

    <h2 id="wound">Wound</h2>
    <?php $person->makeProtection(); ?>
    <?php /* $person->buildCard($person->getAttribute($person->world->attributeBody)); */ ?>
    <?php /* $person->buildCard($person->getAttribute($person->world->attributeDamage)); */ ?>
    <?php $person->makeWound(); ?>

    <?php if($person->isOwner): ?>
        <div class="sw-l-content__wrap">
            <a class="sw-c-link sw-c-link--dangerous" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/wound">Add Wound</a>
        </div>
    <?php endif; ?>



    <h2>Equipment</h2>
    <h3>Weapon</h3>
    <?php $person->makeWeaponEquip(); ?>

    <?php if($person->isOwner): ?>
        <div class="sw-l-content__wrap">
            <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/weapon">Edit Weapon</a>
        </div>
    <?php endif; ?>

    <h3 id="protection">Protection</h3>
    <?php $person->makeProtectionEquip(); ?>

    <?php if($person->isOwner): ?>
        <div class="sw-l-content__wrap">
            <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/protection">Edit Protection</a>
        </div>
    <?php endif; ?>

    <?php if($person->world->existsBionic): ?>
        <h3 id="bionic">Bionic</h3>
        <?php $person->makeList($person->getBionic()); ?>

        <?php if($person->isOwner): ?>
            <div class="sw-l-content__wrap">
                <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/bionic/bionic">Edit Bionic</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($person->world->existsAugmentation): ?>
        <h3 id="augmentation">Augmentation</h3>
        <?php $person->makeList($person->getAugmentation()); ?>

        <?php if($person->isOwner): ?>
            <div class="sw-l-content__wrap">
                <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/bionic/augmentation">Edit Augmentation</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>



    <h2>Description</h2>
    <div class="sw-l-content__wrap">
        <?php
        if($person->description != null || $person->behaviour != null || $person->appearance != null || $person->features != null || $person->personality != null) {
            if($person->description != null) echo('<p>'.$person->description.'</p>');
            if($person->behaviour != null) echo('<p>'.$person->behaviour.'</p>');
            if($person->appearance != null) echo('<p>'.$person->appearance.'</p>');
            if($person->features != null) echo('<p>'.$person->features.'</p>');
            if($person->personality != null) echo('<p>'.$person->personality.'</p>');
        } else {
            echo('<p>Awfully empty here. Perhaps you would like to describe your character now?</p>');
        }
        ?>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/description">Edit Description</a>
    </div>




    <h2>Features</h2>
    <?php $person->makeFeatures(); ?>
    <?php $person->makeExpertiseList(); ?>

    <?php if($person->isSupernatural) { $person->makeCard($person->getAttribute($person->world->attributePower)); } ?>

    <?php $person->makeCard($person->getAttribute($person->world->attributeExperience)); ?>

    <?php if($person->isOwner): ?>
        <div class="sw-l-content__wrap">
            <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level">Level Up</a>
        </div>
    <?php endif; ?>

<?php endif; ?>