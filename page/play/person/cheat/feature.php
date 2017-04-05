<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:05
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

$component->title('Cheat '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php if($sitemap->context): ?>

        <?php
        $list = null;

        $form->formStart();

        switch($sitemap->context)
        {
            default: break;

            case 'species':
                $list = $person->world->getSpecies();
                $form->hidden('current_id', $person->species->id, 'person');
                break;

            case 'background':
                $list = $person->world->getBackground($person->species->id);
                $form->hidden('current_id', $person->background->id, 'person');
                break;

            case 'nature':
                $list = $person->world->getNature();
                $form->hidden('current_id', $person->nature->id, 'person');
                break;

            case 'identity':
                $list = $person->world->getIdentity();
                $form->hidden('current_id', $person->identity->id, 'person');
                break;

            case 'manifestation':
                $list = $person->world->getManifestation();
                $form->hidden('current_id', $person->manifestation->id, 'person');
                break;

            case 'focus':
                $list = $person->world->getFocus($person->manifestation->id);
                $form->hidden('current_id', $person->focus->id, 'person');
                break;
        }

        $form->hidden('return', 'play', 'post');
        $form->hidden('do', 'person--feature--edit', 'post');
        $form->hidden('id', $person->id, 'post');
        $form->hidden('hash', $person->hash, 'post');
        $form->hidden('context', $sitemap->context, 'post');

        $component->h2($sitemap->context);

        $system->radioList($sitemap->context, $list);

        $form->formEnd();
        ?>

        <script src="/js/validation.js"></script>

    <?php else: ?>

        <?php
        $component->wrapStart();
        $component->h2('Feature');
        $component->linkButton($person->siteLink.'/cheat/feature/species','Species');
        $component->linkButton($person->siteLink.'/cheat/feature/background','Background');
        $component->linkButton($person->siteLink.'/cheat/feature/nature','Nature');
        $component->linkButton($person->siteLink.'/cheat/feature/identity','Identity');

        if($person->isSupernatural) {
            $component->linkButton($person->siteLink.'/cheat/feature/manifestation','Manifestation');
            $component->linkButton($person->siteLink.'/cheat/feature/focus','Focus');
        }

        $component->wrapEnd();
        ?>

    <?php endif; ?>

<?php endif; ?>
