<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:48
 */
global $sitemap, $system;

$person = isset($sitemap->unique)
    ? new Person(null, $sitemap->unique)
    : null;

?>

<?php if($person): ?>

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
