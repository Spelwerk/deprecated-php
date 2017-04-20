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

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php if($sitemap->context == 'add'): ?>

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
                $person->buildRemoval('weapon', $item->id, $item->name, $item->icon);
            }
        }

        $component->linkButton($person->siteLink.'/edit/weapon/add','Add');
        ?>

    <?php endif; ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>