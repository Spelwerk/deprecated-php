<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:05
 */
global $sitemap;
$person = new Person($sitemap->id, $sitemap->hash);

?>
<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<?php if($sitemap->thing): ?>

    <script src="/js/edit_radio.js"></script>

    <form action="/post.php" method="post">

        <?php
        global $form;

        $system = new System();

        $list = null;

        switch($sitemap->thing)
        {
            default: break;

            case 'species':
                $list = $system->getSpeciesList($person->world->id);
                $form->getHidden('person', 'current_id', $person->species->id);
                break;

            case 'caste':
                $list = $system->getCasteList($person);
                $form->getHidden('person', 'current_id', $person->caste->id);
                break;

            case 'nature':
                $list = $system->getNatureList($person);
                $form->getHidden('person', 'current_id', $person->nature->id);
                break;

            case 'identity':
                $list = $system->getIdentityList($person);
                $form->getHidden('person', 'current_id', $person->identity->id);
                break;

            case 'manifestation':
                $list = $system->getManifestationList($person);
                $form->getHidden('person', 'current_id', $person->manifestation->id);
                break;

            case 'focus':
                $list = $system->getFocusList($person);
                $form->getHidden('person', 'current_id', $person->focus->id);
                break;
        }

        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--edit--feature');
        $form->getHidden('post', 'id', $person->id);
        $form->getHidden('post', 'hash', $person->hash);

        echo('<h2>'.$sitemap->thing.'</h2>');

        $form->genericSelect('person', $sitemap->thing.'_id', $list);
        ?>

        <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
    </form>

<?php else: ?>

    <div class="sw-l-content__wrap">
        <h2>Feature</h2>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/species">Species</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/caste">Caste</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/nature">Nature</a>
        <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/identity">Identity</a>

        <?php if($person->isSupernatural): ?>
            <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/manifestation">Manifestation</a>
            <a class="sw-c-link" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>/edit/feature/focus">Focus</a>
        <?php endif; ?>
    </div>

<?php endif; ?>