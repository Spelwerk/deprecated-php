<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
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

    <h2>Add Weapon</h2>
    <?php $system->person_checkWeapon($person); ?>

<?php else: ?>

    <h2>Weapon</h2>
    <?php
    $list = $person->getWeapon();

    if(isset($list)) {
        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'weapon');
        }
    }
    ?>
    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/weapon/add">Add</a>
    </div>

<?php endif; ?>