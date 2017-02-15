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

<?php if($sitemap->thing == 'upbringing'): ?>

    <script src="/js/play.js"></script>

    <h2>Upbringing</h2>
    <?php
    global $form;

    $system = new System();

    $system->makeMilestoneSelect($person, 1, 1);
    ?>

<?php endif; ?>

<?php if($sitemap->thing == 'flexible'): ?>

    <script src="/js/play.js"></script>

    <h2>Flexible</h2>
    <?php
    global $form;

    $system = new System();

    $system->makeMilestoneSelect($person, 0, 1);
    ?>

<?php endif; ?>

<?php if(!$sitemap->thing): ?>

    <h2>Milestone</h2>
    <?php
    $list = $person->getMilestone();

    foreach($list as $item) {
        $person->buildRemoval($item->id, $item->name, $item->icon, 'milestone');
    }
    ?>
    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/milestone/upbringing">Add Upbringing</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/milestone/flexible">Add Flexible</a>
    </div>

<?php endif; ?>