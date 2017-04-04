<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php if($sitemap->thing == 'add'): ?>

    <?php
    $component->h2('Add Weapon');
    $system->person_checkWeapon($person);
    ?>

<?php else: ?>

    <?php
    $list = $person->getWeapon();

    $component->h2('Weapon');

    if(isset($list)) {
        foreach($list as $item) {
            $person->buildRemoval($item->id, $item->name, $item->icon, 'weapon');
        }
    }

    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/weapon/add','Add');
    ?>

<?php endif; ?>

<script src="/js/play_create.js"></script>
