<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
 */
global $sitemap, $form;
$person = new Person($sitemap->id, $sitemap->hash);

?>

<?php if($sitemap->thing == 'gift'): ?>

    <script src="/js/play.js"></script>

    <h2>Gift</h2>
    <?php
    global $form;

    $system = new System();

    $system->makeCharacteristicSelect($person, 1, 1);
    ?>

<?php endif; ?>

<?php if($sitemap->thing == 'imperfection'): ?>

    <script src="/js/play.js"></script>

    <h2>Imperfection</h2>
    <?php
    global $form;

    $system = new System();

    $system->makeCharacteristicSelect($person, 0, 1);
    ?>

<?php endif; ?>

<?php if(!$sitemap->thing): ?>

    <h2>Characteristic</h2>
    <?php
    $list = $person->getCharacteristic();

    foreach($list as $item) {
        $person->buildRemoval($item->id, $item->name, $item->icon, 'characteristic');
    }
    ?>
    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/cheat/characteristic/gift">Add Gift</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/cheat/characteristic/imperfection">Add Imperfection</a>
    </div>

<?php endif; ?>