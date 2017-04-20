<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 13:26
 */
global $sitemap, $user, $form, $component;

require_once('./class/Story.php');

$story = null;
$userOwner = null;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $story = new Story($sitemap->id, $sitemap->hash);
} else if (isset($sitemap->id)) {
    $story = new Story($sitemap->id);
}
?>

<?php if($story): ?>

    <div class="sw-js-story-name sw-is-hidden"><?php echo($story->name); ?></div>

    <?php
    if($user->isActive) {
        $list = $user->getStory();

        if($list) {
            foreach($list as $item) {
                if($sitemap->id == $item['story_id'] && $sitemap->hash == $item['story_hash']) {
                    $userOwner = true;
                }
            }
        }
    }
    ?>

    <?php $component->title($story->name); ?>

    <?php if($story->isOwner): ?>

        <div class="sw-l-quicklink">
            <?php
            $component->linkQuick($story->siteLink.'/location','Location','/img/story-location.png');
            $component->linkQuick($story->siteLink.'/meeting','Meeting','/img/story-meeting.png');
            $component->linkQuick($story->siteLink.'/person','Person','/img/link-person.png');
            $component->linkQuick($story->siteLink.'/edit','Edit','/img/edit.png');
            ?>
        </div>

        <?php if($user->isActive && $userOwner != true): ?>

            <?php
            $form->formStart([
                'do' => 'user--save--story',
                'id' => $story->id,
                'hash' => $story->hash,
                'user' => $user->id,
                'return' => 'play/story/id'
            ]);
            $form->formEnd(false, 'Save this story');
            ?>

        <?php endif; ?>

    <?php endif; ?>

    <?php
    $component->sectionStart();

    $component->h1('Description');
    $component->subtitle('World is: '.$story->world->name);
    $component->p($story->description);

    $component->h1('Plot');
    $component->p($story->plot);

    $component->h1('Roll');
    $story->makeButton();

    $component->h1('Weapon');
    $story->makeWeapon();

    $component->h1('Person');
    $story->makePerson();

    $component->sectionEnd();
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
