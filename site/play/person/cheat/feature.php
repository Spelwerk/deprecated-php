<?php global $component, $form, $person, $system, $sitemap;

if($person->isOwner) {

    $list = null;
    $currentId = null;

    if($sitemap->extra2) {
        $component->h2($sitemap->extra2);
        $form->formStart([
            'do' => 'person--'.$sitemap->extra2,
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);
    }

    switch($sitemap->extra2)
    {
        default:
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
            break;

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

    if($sitemap->extra2) {
        $form->hidden('extra', $currentId, 'post');
        $form->radioList($list, [
            'currentId' => $currentId
        ]);
        $form->formEnd();
    }
}
?>