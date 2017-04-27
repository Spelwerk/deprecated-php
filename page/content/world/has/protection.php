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
}
?>

<?php if($sitemap->context == 'add'): ?>

    <?php
    $component->returnButton($world->siteLink.'/protection');
    $world->postProtection();
    ?>

<?php elseif($sitemap->context == 'delete'): ?>

    <?php
    $component->returnButton($world->siteLink.'/protection');
    $world->deleteProtection();
    ?>

<?php else: ?>

    <?php
    $component->returnButton($world->siteLink);
    $component->h1('Protection');

    $list = $world->getProtection();

    if($list[0]) {
        foreach($list as $item) {
            $component->listItem($item->name, $item->description, $item->icon);
        }
    }

    $component->linkButton($world->siteLink.'/protection/add','Add');
    $component->linkButton($world->siteLink.'/protection/delete','Delete',true);
    ?>

<?php endif; ?>

<script src="/js/validation.js"></script>
<script src="/js/play.js"></script>