<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 07/04/2017
 * Time: 13:27
 */
global $sitemap, $form, $component;

require_once('./class/Story.php');

$story = new Story($sitemap->id, $sitemap->hash);

$component->title('Edit '.$story->name);
?>

<?php if($story->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($story->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $component->wrapStart();
    $form->formStart([
        'do' => 'story--edit',
        'id' => $story->id,
        'hash' => $story->hash,
        'return' => 'play/story/id'
    ]);
    $form->varchar(true,'name','Name','The name of your story will make it easier to remember which one it is.',null,$story->name);
    $form->text(false,'description','Description', 'Describe your Story. This field can be added to in the future.',null,$story->description);
    $form->text(false,'plot','Plot','Describe the plot of your Story. This field can be added to in the future.',null,$story->plot);
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>