<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 19:16
 */
global $sitemap, $form;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if($sitemap->thing == 'add'): ?>

    <script src="/js/play.js"></script>

    <h2>Add Protection</h2>
    <?php $system->person_checkProtection($person); ?>

<?php else: ?>

    <h2>Protection</h2>
    <?php
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