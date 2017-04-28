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
        $currentId = null;

        $component->h2($sitemap->context);
        $form->formStart([
            'do' => 'person--'.$sitemap->context,
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        switch($sitemap->context)
        {
            default: break;

            case 'species':
                $list = $person->world->getSpecies();
                $currentId = $person->species->id;
                break;

            case 'background':
                $list = $person->world->getBackground('/species/'.$person->species->id);
                $currentId = $person->background->id;
                break;

            case 'nature':
                $list = $person->world->getNature();
                $currentId = $person->nature->id;
                break;

            case 'identity':
                $list = $person->world->getIdentity();
                $currentId = $person->identity->id;
                break;

            case 'manifestation':
                $list = $person->world->getManifestation();
                $currentId = $person->manifestation->id;
                break;

            case 'focus':
                $list = $person->world->getFocus($person->manifestation->id);
                $currentId = $person->focus->id;
                break;
        }
        $form->hidden('extra', $currentId, 'post');
        $system->radioList($sitemap->context.'_id', $list, null, $currentId);
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
