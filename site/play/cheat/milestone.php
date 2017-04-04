<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
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
    $component->h2('Milestone');
    $system->person_selectMilestone($person, 1);
    ?>

<?php endif; ?>

<?php if(!$sitemap->thing): ?>

    <h2>Milestone</h2>
    <?php
    $list = $person->getMilestone();

    $component->wrapStart();

    foreach($list as $item) {
        $person->buildRemoval($item->id, $item->name, $item->icon, 'milestone');
    }

    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat/milestone/add','Add Milestone');
    $component->wrapEnd();
    ?>

<?php endif; ?>

<script src="/js/play_create.js"></script>
