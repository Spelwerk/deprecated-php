<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 17:17
 */
global $sitemap, $component, $form;

require_once('./class/Story.php');

$story = new Story($sitemap->id, $sitemap->hash);

$component->title('Edit '.$story->name);
?>

<?php if($story->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($story->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $component->h2('Add Person');
    $component->wrapStart();
    $form->formStart();

    $form->hidden('return', 'play/story/id', 'post');
    $form->hidden('do', 'story--person--add', 'post');
    $form->hidden('id', $story->id, 'post');
    $form->hidden('hash', $story->hash, 'post');

    $form->varchar(false,'person_link','Full Link','You can paste the copied link from a friend into this field if you wish.',null,null,'https://spelwerk.com/play/person/id/{id}');
    $form->number(false,'person_id','Person ID','Type the ID for the person you wish to add into this story');
    //$form->varchar(false,'person_hash','Person Hash','DESC');
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>