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

<?php if($person): ?>

    <?php if($person->isPlayable && $sitemap->hash && !$person->isCalculated): ?>

        <?php
        require_once('./class/System.php');

        $system = new System();
        $system->createPerson($person);
        ?>

        <script src="/js/validation.js"></script>
        <script src="/js/play.js"></script>

    <?php else: ?>

        <?php $component->title($person->nickname); ?>

        <?php if($person->isPlayable && $person->isCalculated && $person->isOwner): ?>

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

                if($userOwner != true) {
                    $form->formStart([
                        'do' => 'user--save',
                        'context' => 'person',
                        'id' => $person->id,
                        'secret' => $person->secret,
                        'return' => 'play/person/id',
                        'user' => $user-id
                    ]);
                    $form->formEnd(false, 'Save this person');
                }
            }
            ?>

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

        <?php endif; ?>

        <?php
        $component->sectionStart();
        $component->p('This is '.$person->firstname.' "'.$person->nickname.'" '.$person->surname.'. '.$person->firstname.' is a '.$person->occupation);

        if($person->isPlayable && $person->isCalculated) {
            $component->p($person->firstname.' is '.$person->age.' years old. '.$person->firstname.'\'s gender is '.$person->gender);
        }

        $component->sectionEnd();

        if($person->isPlayable && $person->isCalculated) {
            $component->sectionStart();
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

            $component->sectionEnd();

            $component->sectionStart('sw-is-gray');

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

            $component->sectionEnd();
        }

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

        if($person->isPlayable && $person->isCalculated) {
            $component->h2('Features');
            $person->makeFeatures();
            $person->makeExpertiseList();
            $person->makeAttributeList();

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

            $person->makeAugmentation();

            $component->h1('Reminder');
            $component->linkButton('#','Bookmark this Person',true,'sw-js-bookmark');
        }

        ?>

        <div class="sw-js-modal sw-c-modal sw-is-hidden">
            <div class="sw-js-modal-title sw-c-modal__title">Title</div>
            <div class="sw-c-modal__content">
                <div class="sw-c-modal__body">
                    <div class="sw-js-modal-with sw-c-modal__body__with sw-is-hidden"></div>
                    <div class="sw-js-modal-result sw-c-modal__body__result sw-is-hidden"></div>
                    <div class="sw-js-modal-critical sw-c-modal__body__critical sw-is-hidden">Press the dice to roll</div>
                    <div class="sw-js-modal-count sw-c-modal__body__count sw-is-hidden"></div>
                    <div class="sw-js-modal-description sw-c-modal__body__description sw-is-hidden"></div>
                </div>
                <div class="sw-c-modal__button">
                    <div class="sw-js-modal-info sw-c-modal__button__item"><img src="/img/modal/info.png"/></div>
                    <div class="sw-js-modal-close sw-c-modal__button__item"><img src="/img/modal/close.png"/></div>
                    <div class="sw-js-modal-roll sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/dice.png"/></div>
                    <div class="sw-js-modal-consumable sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/dice.png"/></div>
                    <div class="sw-js-modal-supernatural sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/magic.png"/></div>
                    <div class="sw-js-modal-weapon sw-c-modal__button__item sw-is-hidden"><img src="/img/modal/damage.png"/></div>
                </div>
            </div>
        </div>

        <div class="sw-js-modal-mask sw-u-mask sw-is-hidden"></div>
        <div class="sw-js-saved-critical sw-is-hidden">0</div>
        <div class="sw-js-roll-modifier sw-is-hidden">0</div>

        <script src="/js/play.js"></script>

    <?php endif; ?>

<?php endif; ?>

