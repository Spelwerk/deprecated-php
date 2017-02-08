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

    <h1>Person</h1>
    <?php //print_r($person); ?>

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

    <?php if($person->supernatural): ?>

        <h2>Potential</h2>
        <?php if($person->supernatural) $person->buildCard($person->getAttribute($person->world->attributePotential)); ?>

    <?php endif; ?>

    <h2>Protection</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeProtection)); ?>

    <h2>Reputation</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeReputation)); ?>

    <h2>Skill</h2>
    <?php $person->makeSkill($person->getAttribute($person->world->attributeSkill)); ?>

    <h1>Expertise</h1>
    <?php $person->makeExpertise(); ?>

    <?php if($person->supernatural): ?>

        <h2>Supernatural</h2>
        <?php $person->makeSupernatural(); ?>

    <?php endif; ?>

    <h1>Weapon</h1>
    <?php $person->makeWeapon(); ?>

    <h2>Wound</h2>
    <?php $person->buildCard($person->getAttribute($person->world->attributeWound)); ?>

<?php endif; ?>
