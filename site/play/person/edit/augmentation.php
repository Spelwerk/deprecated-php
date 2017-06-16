<?php global $component, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Augmentation');
    $component->subtitle('Once attached. Augmentations cannot be removed.');

    if($sitemap->extra2 == 'add') {
        $person->postAugmentation($sitemap->extra3);
    } else {
        $bionicList = $person->getBionic();

        $component->wrapStart();

        if($bionicList) {
            foreach($bionicList as $bionic) {
                $component->linkButton($person->siteLink.'/edit/augmentation/add/'.$bionic->id,$bionic->name);
            }
        }

        $component->wrapEnd();
    }
}
?>