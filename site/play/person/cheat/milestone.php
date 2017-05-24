<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Milestone');

    if ($sitemap->context2 == 'add') {
        $person->postMilestone();
    } else {
        $list = $person->getMilestone();

        $component->wrapStart();

        foreach ($list as $item) {
            $person->buildRemoval('milestone', $item->id, $item->name, $item->icon);
        }

        $component->linkButton($person->siteLink . '/cheat/milestone/add', 'Add Milestone');
        $component->wrapEnd();
    }
}
?>