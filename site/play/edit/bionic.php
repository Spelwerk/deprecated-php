<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
 */
global $sitemap;
$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

?>

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
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/bionic/bionic">Bionic</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/level/bionic/augmentation">Augmentation</a>
    </div>

<?php endif; ?>