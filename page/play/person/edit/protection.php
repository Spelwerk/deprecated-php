<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 19:16
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
        $component->h2('Add Protection');
        $system->person_checkProtection($person);
        ?>

    <?php else: ?>

        <?php
        $list = $person->getProtection();

        $component->h2('Protection');

        if(isset($list)) {
            foreach($list as $item) {
                $person->buildRemoval($item->id, $item->name, $item->icon, 'protection');
            }
        }

        $component->linkButton($person->siteLink.'/edit/protection/add','Add');
        ?>

    <?php endif; ?>

<script src="/js/validation.js"></script>

<?php endif; ?>