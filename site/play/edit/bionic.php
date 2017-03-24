<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
 */
global $sitemap;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if($sitemap->thing == 'augmentation'): ?>

    <script src="/js/play.js"></script>

    <h2>Add Augmentation</h2>
    <h4>Once attached. Augmentations cannot be removed.</h4>
    <?php
    $system = new System();

    $system->person_checkAugmentation($person);
    ?>

<?php endif; ?>

<?php if($sitemap->thing == 'bionic'): ?>

    <script src="/js/play.js"></script>

    <h2>Add Bionic</h2>
    <h4>Once attached. Bionics cannot be removed.</h4>
    <?php
    $system = new System();

    $system->person_checkBionic($person);
    ?>

<?php endif; ?>

<?php if(!$sitemap->thing): ?>

    <h2>Bionic & Augmentation</h2>
    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/bionic/bionic">Bionic</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/bionic/augmentation">Augmentation</a>
    </div>

<?php endif; ?>