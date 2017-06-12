<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    switch($sitemap->extra)
    {
        default:
            if($person->isCheater) {
                $component->wrapStart();
                $component->linkButton($person->siteLink.'/cheat/attribute','Attribute');
                $component->linkButton($person->siteLink.'/cheat/expertise','Expertise');
                $component->linkButton($person->siteLink.'/cheat/feature','Feature');
                $component->linkButton($person->siteLink.'/cheat/gift', 'Gift');
                $component->linkButton($person->siteLink.'/cheat/imperfection', 'Imperfection');
                $component->linkButton($person->siteLink.'/cheat/milestone','Milestone');
                $component->linkButton($person->siteLink.'/cheat/skill','Skill');

                if($person->isSupernatural) {
                    $component->linkButton($person->siteLink.'/cheat/doctrine','Doctrine');
                }

                $component->wrapEnd();
            } else {
                $component->h1('Cheat');
                $component->subtitle('There are options in this place that will let you change your person into something that is outside of the normal creation structure. Because of this we will remove your person from all public lists if you choose to move forward and cheat.');
                $component->wrapStart();
                $form->form([
                    'do' => 'person--cheat',
                    'id' => $person->id,
                    'return' => 'play/person',
                    'returnafter' => 'cheat'
                ]);
                $form->submit(false, 'Cheat');
                $component->wrapEnd();
            }
            break;

        case 'attribute':
            require_once('./site/content/person/cheat/attribute.php');
            break;

        case 'doctrine':
            $component->returnButton($person->siteLink);
            $component->h2('Doctrine');
            $person->postDoctrine(true);
            break;

        case 'expertise':
            $component->returnButton($person->siteLink);
            $component->h2('Expertise');
            $person->postExpertise(true);
            break;

        case 'feature':
            require_once('./site/content/person/cheat/feature.php');
            break;

        case 'gift':
            require_once('./site/content/person/cheat/gift.php');
            break;

        case 'imperfection':
            require_once('./site/content/person/cheat/imperfection.php');
            break;

        case 'milestone':
            require_once('./site/content/person/cheat/milestone.php');
            break;

        case 'skill':
            $component->returnButton($person->siteLink);
            $component->h2('Skill');
            $person->postSkill(true);
            break;
    }
}
?>