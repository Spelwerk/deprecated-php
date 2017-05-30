<?php global $component, $sitemap, $system;

if($sitemap->index) {
    $skill = new Skill($sitemap->index);

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