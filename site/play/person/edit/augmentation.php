<?php global $component, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Augmentation');
    $component->subtitle('Once attached. Augmentations cannot be removed.');

    if($sitemap->context2 == 'add') {
        $person->postAugmentation($sitemap->context);
    } else {
        $bionicList = $person->getBionic();

        $component->wrapStart();

        foreach($bionicList as $bionic) {
            $component->linkButton($person->siteLink.'/edit/augmentation/'.$bionic->id,$bionic->name);
        }

        $component->wrapEnd();
    }
}
?>