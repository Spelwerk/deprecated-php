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
    <?php print_r($person); ?>

    <h2>Gift</h2>
    <?php print_r($person->getCharacteristic(1)); ?>

    <h2>Imperfection</h2>
    <?php print_r($person->getCharacteristic(0)); ?>

    <h2>Upbringing</h2>
    <?php print_r($person->getMilestone(1)); ?>

    <h2>Milestone</h2>
    <?php print_r($person->getMilestone(0)); ?>

    <h1>Attributes</h1>

    <h2>Body</h2>
    <?php print_r($person->getAttribute($person->world->attributeBody)); ?>

    <h2>Combat</h2>
    <?php print_r($person->getAttribute($person->world->attributeCombat)); ?>

    <h2>Consumable</h2>
    <?php print_r($person->getAttribute($person->world->attributeConsumable)); ?>

    <h2>Damage</h2>
    <?php print_r($person->getAttribute($person->world->attributeDamage)); ?>

    <h2>Experience</h2>
    <?php print_r($person->getAttribute($person->world->attributeExperience)); ?>

    <h2>Potential</h2>
    <?php if($person->supernatural) print_r($person->getAttribute($person->world->attributePotential)); ?>

    <h2>Protection</h2>
    <?php print_r($person->getAttribute($person->world->attributeProtection)); ?>

    <h2>Reputation</h2>
    <?php print_r($person->getAttribute($person->world->attributeReputation)); ?>

    <h2>Skill</h2>
    <?php print_r($person->getAttribute($person->world->attributeSkill)); ?>

    <h2>Wound</h2>
    <?php print_r($person->getAttribute($person->world->attributeWound)); ?>

    <h2>Supernatural</h2>
    <?php if($person->supernatural) print_r($person->getAttribute($person->manifestation->attributeType)); ?>

    <h1>Expertise</h1>
    <?php print_r($person->getExpertise()); ?>

    <h1>Weapon</h1>
    <?php print_r($person->getWeapon()); ?>

<?php endif; ?>
