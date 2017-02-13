<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 10:55
 */
global $sitemap;

$system = new System();

$person = null;
$calculated = false;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $person = new Person($sitemap->id, $sitemap->hash);

    $calculated = $person->isCalculated == true
        ? true
        : false;

} else if (isset($sitemap->id)) {
    $person = new Person($sitemap->id);

}

$world = isset($_POST['person--world_id'])
    ? $world = new World($_POST['person--world_id'])
    : null;

$species = isset($_POST['person--species_id'])
    ? new Species($_POST['person--species_id'])
    : null;

?>

<script src="/js/play.js"></script>

<?php if(!$calculated): ?>

    <?php $system->createPerson($person, $world, $species); ?>

<?php endif; ?>



<?php if($person && $person->isCalculated): ?>

    <h2><?php echo($person->firstname.' '.$person->surname); ?></h2>

    <h2>Short</h2>
    <?php echo
    (
        '<p>Name: '.$person->firstname.' "'.$person->nickname.'" '.$person->surname.'</p>'.
        '<p>Age: '.$person->age.'. Gender: '.$person->gender.'. Occupation: '.$person->occupation.'.</p>'
    );
    ?>

    <?php if(!isset($person->description) && !isset($person->behaviour) && !isset($person->appearance) && !isset($person->features) && !isset($person->personality)): ?>

        <h2>Description</h2>
        <?php
        if(isset($person->description)) echo('<p>'.$person->description.'</p>');
        if(isset($person->behaviour)) echo('<p>'.$person->behaviour.'</p>');
        if(isset($person->appearance)) echo('<p>'.$person->appearance.'</p>');
        if(isset($person->features)) echo('<p>'.$person->features.'</p>');
        if(isset($person->personality)) echo('<p>'.$person->personality.'</p>');
        ?>

    <?php endif; ?>

    <h2>Features</h2>
    <?php $person->makeFeatures(); ?>

    <?php $person->buildCard($person->getAttribute($person->world->attributeExperience)); ?>

    <h2>Characteristics</h2>
    <?php $person->makeCharacteristic(); ?>

    <h2>Milestone</h2>
    <?php $person->makeMilestone(); ?>

    <?php if($person->isSupernatural): ?>

        <h2><?php echo $person->world->supernaturalName; ?></h2>
        <?php $person->makeSupernaturalInformation(); ?>

        <?php $person->buildCard($person->getAttribute($person->world->attributePotential)); ?>

    <?php endif; ?>

    <h2>Consumable</h2>
    <?php $person->makeConsumable($person->getAttribute($person->world->attributeConsumable)); ?>

    <h2>Reputation</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeReputation)); ?>

    <h2>Skill</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeSkill)); ?>

    <h2>Expertise</h2>
    <?php $person->makeExpertise(); ?>

    <?php if($person->isSupernatural): ?>

        <h2>Supernatural</h2>
        <?php $person->makeSupernatural(); ?>

    <?php endif; ?>

    <h2>Weapon</h2>
    <?php $person->makeWeapon(); ?>

    <h2>Combat</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeCombat)); ?>
    <?php $person->buildCard($person->getAttribute($person->world->attributeBody)); ?>
    <?php $person->buildCard($person->getAttribute($person->world->attributeDamage)); ?>
    <?php $person->buildCard($person->getAttribute($person->world->attributeProtection), '--small'); ?>
    <?php $person->buildCard($person->getAttribute($person->world->attributeWound)); ?>

<?php endif; ?>