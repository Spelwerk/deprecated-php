<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 22:31
 */
global $sitemap, $user, $form, $component;

require_once('./class/Person.php');

$person = null;
$userOwner = null;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $person = new Person($sitemap->id, $sitemap->hash);
} else if (isset($sitemap->id)) {
    $person = new Person($sitemap->id);
}
?>

<div class="sw-js-person-name sw-is-hidden"><?php echo($person->nickname); ?></div>

<?php if($person && $sitemap->hash && !$person->isCalculated): ?>

    <?php
    require_once('./class/System.php');

    $system = new System();
    $system->createPerson($person, null, null);
    ?>

    <script src="/js/validation.js"></script>
    <script src="/js/play.js"></script>

<?php endif; ?>

<?php if($person && $person->isCalculated): ?>

    <?php
    if($user->isActive) {
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

    <?php $component->title($person->nickname); ?>

    <?php if($person->isOwner): ?>

        <div class="sw-l-quicklink">
            <?php
            $component->linkQuick($person->siteLink.'/wound','Wound','/img/wound-wound.png');
            $component->linkQuick($person->siteLink.'/edit/weapon','Weapon','/img/weapon.png');
            $component->linkQuick($person->siteLink.'/edit/protection','Protection','/img/armor.png');

            if($person->world->existsBionic) {
                $component->linkQuick($person->siteLink.'/edit/bionic','Bionic','/img/bionic.png');
            }

            $component->linkQuick($person->siteLink.'/edit','Edit','/img/edit.png');
            ?>
        </div>

        <?php if($user->isActive && $userOwner != true): ?>

            <?php
            $form->formStart();
            $form->hidden('return', 'play', 'post');
            $form->hidden('do', 'user--save--person', 'post');
            $form->hidden('id', $person->id, 'post');
            $form->hidden('hash', $person->hash, 'post');
            $form->hidden('user', $user->id, 'post');
            $form->formEnd(false, 'Save this person');
            ?>

        <?php endif; ?>

    <?php endif; ?>

    <?php
    echo('<div class="sw-l-content">');

    $component->wrapStart();
    $component->p('This is '.$person->firstname.' "'.$person->nickname.'" '.$person->surname.'. '.$person->firstname.' is a '.$person->age.' years old '.$person->gender.' '.$person->occupation.'');
    $component->h2('Skill');
    $person->makeButton($person->getAttribute($person->world->attributeSkill), 'skill');
    $person->makeExpertise();
    $person->makeSupernatural();

    $component->h2('Weapon', 'weapon');
    $person->makeButton($person->getWeapon(1), 'weapon');

    $component->h2('Consumable');
    $person->makeButton($person->getAttribute($person->world->attributeConsumable), 'consumable');

    $component->h2('Attribute');
    $person->makeButton($person->getAttribute($person->world->attributeReputation), 'skill');
    $person->makeButton($person->getAttribute($person->world->attributeCombat), 'skill');

    $component->wrapEnd();

    echo('</div><div class="sw-l-content sw-is-gray">');

    $component->h2('Wound', 'wound');
    $person->makeWound();

    if($person->isOwner) {
        $component->linkButton($person->siteLink.'/wound','Add Wound');
    }

    $component->h2('Disease','disease');
    $person->makeDisease();

    if($person->isOwner) {
        $component->linkButton($person->siteLink.'/disease','Add Disease');
    }

    $component->h2('Sanity','sanity');
    $person->makeSanity();

    if($person->isOwner) {
        $component->linkButton($person->siteLink.'/sanity','Add Sanity');
    }

    echo('</div>');

    $component->wrapStart();
    $component->h2('Description');

    if($person->description != null) {
        $component->p($person->description);
    }

    if($person->personality != null) {
        $component->p($person->personality);
    }

    if($person->isOwner) {
        $component->link($person->siteLink.'/edit/description','Edit Description');
    }

    $component->wrapEnd();

    $component->h2('Features');
    $person->makeFeatures();
    $person->makeExpertiseList();

    if($person->isSupernatural) {
        $person->makeCard($person->getAttribute($person->world->attributePower));
    }

    $person->makeCard($person->getAttribute($person->world->attributeExperience));

    if($person->isOwner) {
        $component->linkButton($person->siteLink.'/edit', 'Level Up', '/img/arrow-up.png');
    }

    $component->h2('Equipment');
    $component->h3('Weapon','eq_weapon');
    $person->makeWeaponEquip();

    if($person->isOwner) {
        $component->link($person->siteLink.'/edit/weapon','Edit Weapon');
    }

    $component->h3('Protection','eq_protection');
    $person->makeProtectionEquip();

    if($person->isOwner) {
        $component->link($person->siteLink.'/edit/protection','Edit Protection');
    }

    if($person->world->existsBionic) {
        $component->h3('Bionic','eq_bionic');
        $person->makeList($person->getBionic());

        if($person->isOwner) {
            $component->link($person->siteLink.'/edit/bionic','Edit Bionic');
        }
    }

    if($person->world->existsAugmentation) {
        $component->h3('Augmentation','eq_augmentation');
        $person->makeList($person->getAugmentation());

        if($person->isOwner) {
            $component->link($person->siteLink.'/edit/augmentation','Edit Augmentation');
        }
    }

    $component->linkButton('#','Bookmark this Person',true,'sw-js-bookmark');

    ?>

    <script src="/js/play.js"></script>

<?php endif; ?>
