<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 19:16
 */
global $sitemap;
$person = new Person($sitemap->id, $sitemap->hash);

?>

<?php if($sitemap->thing == 'add'): ?>

    <script src="/js/play.js"></script>

    <h2>Add Protection</h2>
    <?php
    $system = new System();

    $system->makeProtectionSelect($person);
    ?>

<?php else: ?>

    <h2>Protection</h2>
    <?php
    global $form;

    $list = $person->getProtection();

    if(isset($list)) {
        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'protection');
        }
    }
    ?>
    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/protection/add">Add</a>
    </div>

<?php endif; ?>