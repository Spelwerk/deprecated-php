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

    <?php if($sitemap->context == 'add'): ?>

        <?php // todo add person from list of friends who are in the same world
        $component->h2('Add Person');
        $component->wrapStart();
        $form->formStart();

        $form->hidden('return', 'play/story/id', 'post');
        $form->hidden('do', 'story--person--add', 'post');
        $form->hidden('id', $story->id, 'post');
        $form->hidden('hash', $story->hash, 'post');

        $form->varchar(false,'person_link','Full Link','You can paste the copied link from a friend into this field if you wish.',null,null,'https://spelwerk.com/play/story/id/{id}');
        $form->number(false,'person_id','Person ID','Type the ID for the story you wish to add into this story');
        //$form->varchar(false,'person_hash','Person Hash','DESC');
        $form->formEnd();
        $component->wrapEnd();
        ?>

    <?php else: ?>

        <?php
        $list = $story->getPerson();

        $component->h2('Person');

        if(isset($list)) {
            foreach($list as $item) {
                $story->buildRemoval($item['person_id'], $item['person_nickname'], '/img/link-person.png', 'person');
            }
        }

        $component->linkButton($story->siteLink.'/person/add','Add');
        ?>

    <?php endif; ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>