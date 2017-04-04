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

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php if($person->isCheater): ?>

    <?php
    $component->wrapStart();

    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/attribute','Attribute');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/characteristic','Characteristic');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/expertise','Expertise');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/feature','Feature');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/milestone','Milestone');
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/skill','Skill');

    if($person->isSupernatural) {
        $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/supernatural','Supernatural');
    }

    $component->wrapEnd();
    ?>

<?php else: ?>

    <?php
    $component->wrapStart();

    $component->h2('Cheat');
    $component->p('There are options in this place that will let you change your person into something that is outside of the normal creation structure. Because of this we will remove your person from all public lists if you choose to move forward and cheat.');

    $form->formStart();
    $form->hidden('return', 'play', 'post');
    $form->hidden('returnafter', 'cheat', 'post');
    $form->hidden('do', 'person--put', 'post');
    $form->hidden('id', $person->id, 'post');
    $form->hidden('hash', $person->hash, 'post');
    $form->hidden('cheated', 1, 'person');
    $form->formEnd(false, 'Cheat', true);

    $component->wrapEnd();
    ?>

<?php endif; ?>

