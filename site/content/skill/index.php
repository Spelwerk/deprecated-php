<?php global $form, $component, $curl, $sitemap, $system, $user;

if($sitemap->id) {
    $skill = new Skill($sitemap->id);

    $component->title($skill->name);

    switch($sitemap->context)
    {
        default:
            $skill->view();
            break;

        case 'edit':
            $skill->put();
            break;
    }
} else {
    $component->title('Skill');
    $component->returnButton('/content');
    $system->listSkill();
    $component->h4('Create');
    $component->linkButton('/content/create/skill','Create New');
}
?>