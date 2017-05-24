<?php global $component, $sitemap, $system;

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
}
?>