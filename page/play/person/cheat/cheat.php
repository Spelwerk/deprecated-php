<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 08:08
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Cheat '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php if($person->isCheater): ?>

        <?php
        $component->wrapStart();

        $component->linkButton($person->siteLink.'/cheat/attribute','Attribute');
        $component->linkButton($person->siteLink.'/cheat/characteristic', 'Gift');
        $component->linkButton($person->siteLink.'/cheat/expertise','Expertise');
        $component->linkButton($person->siteLink.'/cheat/feature','Feature');
        $component->linkButton($person->siteLink.'/cheat/milestone','Milestone');
        $component->linkButton($person->siteLink.'/cheat/skill','Skill');

        if($person->isSupernatural) {
            $component->linkButton($person->siteLink.'/cheat/doctrine','Doctrine');
        }

        $component->wrapEnd();
        ?>

    <?php else: ?>

        <?php
        $component->wrapStart();
        $component->h1('Cheat');
        $component->subtitle('There are options in this place that will let you change your person into something that is outside of the normal creation structure. Because of this we will remove your person from all public lists if you choose to move forward and cheat.');
        $form->formStart([
            'do' => 'person--cheat',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id',
            'returnafter' => 'cheat'
        ]);
        $form->formEnd(false, 'Cheat', true);
        $component->wrapEnd();
        ?>

    <?php endif; ?>

<?php endif; ?>