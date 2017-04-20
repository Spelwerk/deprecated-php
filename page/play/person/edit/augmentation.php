<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 12:51
 */
global $sitemap, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

$component->title('Edit '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <?php if($sitemap->context): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
    $component->wrapStart();
    $component->h2('Add Augmentation');
    $component->p('Once attached. Augmentations cannot be removed.');
    $component->wrapEnd();

    $system->person_checkAugmentation($person, $sitemap->context);
    ?>

    <script src="/js/validation.js"></script>

    <?php else: ?>

        <div class="sw-l-quicklink">
            <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
        </div>

        <?php
        $bionicList = $person->getBionic();

        $component->wrapStart();
        $component->h2('Add Augmentation to a specific Bionic');
        $component->p('Once attached. Augmentations cannot be removed.');

        foreach($bionicList as $bionic) {
            $component->linkButton($person->siteLink.'/edit/augmentation/'.$bionic->id,$bionic->name);
        }

        $component->wrapEnd();
        ?>

    <?php endif; ?>

<?php endif; ?>