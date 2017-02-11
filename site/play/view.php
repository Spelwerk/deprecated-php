<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/02/2017
 * Time: 11:48
 */
global $sitemap, $system;

$person = isset($sitemap->unique)
    ? new Person($sitemap->unique)
    : null;

?>

<?php if($person): ?>

    <h1>Person</h1>
    <h2>Short</h2>
    <?php echo(
        '<p>Name: '.$person->firstname.' "'.$person->nickname.'" '.$person->surname.'</p>'.
        '<p>Age: '.$person->age.'. Gender: '.$person->gender.'. Occupation: '.$person->occupation.'.</p>'
    );
    ?>

    <h2>Description</h2>
    <?php
    if(isset($person->description)) echo('<p>'.$person->description.'</p>');
    if(isset($person->behaviour)) echo('<p>'.$person->behaviour.'</p>');
    if(isset($person->appearance)) echo('<p>'.$person->appearance.'</p>');
    if(isset($person->features)) echo('<p>'.$person->features.'</p>');
    if(isset($person->personality)) echo('<p>'.$person->personality.'</p>');
    ?>

    <h2>Features</h2>
    <?php $person->makeFeatures(); ?>

    <h2>Characteristics</h2>
    <?php $person->makeCharacteristic(); ?>

    <h2>Milestone</h2>
    <?php $person->makeMilestone(); ?>

    <h1>Attributes</h1>

    <h2>Body</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeBody)); ?>

    <h2>Combat</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeCombat)); ?>

    <h2>Consumable</h2>
    <?php $person->makeConsumable($person->getAttribute($person->world->attributeConsumable)); ?>

    <h2>Damage</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeDamage)); ?>

    <h2>Experience</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeExperience)); ?>

    <?php if($person->isSupernatural): ?>

        <h2>Potential</h2>
        <?php if($person->isSupernatural) $person->buildCard($person->getAttribute($person->world->attributePotential)); ?>

    <?php endif; ?>

    <h2>Protection</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeProtection)); ?>

    <h2>Reputation</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeReputation)); ?>

    <h2>Skill</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeSkill)); ?>

    <h1>Expertise</h1>
    <?php $person->makeExpertise(); ?>

    <?php if($person->isSupernatural): ?>

        <h2>Supernatural</h2>
        <?php $person->makeSupernatural(); ?>

    <?php endif; ?>

    <h1>Weapon</h1>
    <?php $person->makeWeapon(); ?>

    <h2>Wound</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeWound)); ?>

<?php endif; ?>
