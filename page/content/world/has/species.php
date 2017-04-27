<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2017-04-26
 * Time: 16:18
 */
global $sitemap, $user, $form, $component;

require_once('./class/World.php');

if(isset($sitemap->id)) {
    $world = new World($sitemap->id);

    $component->title($world->name);
    $component->returnButton($world->siteLink);
}
?>

<?php if($sitemap->context == 'add'): ?>

    <?php $world->postSpecies(); ?>

<?php elseif($sitemap->context == 'delete'): ?>

    <?php $world->deleteSpecies(); ?>

<?php else: ?>

    <?php
    $component->h1('Species');

    $list = $world->getSpecies();

    if($list[0]) {
        foreach($list as $item) {
            $component->listItem($item->name, $item->description, $item->icon);
        }
    }

    $component->linkButton($world->siteLink.'/species/add','Add');
    $component->linkButton($world->siteLink.'/species/delete','Delete',true);
    ?>

<?php endif; ?>

<script src="/js/validation.js"></script>
<script src="/js/play.js"></script>