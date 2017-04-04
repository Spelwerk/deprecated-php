<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:46
 */
global $sitemap, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php
$component->wrapStart();

//$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/asset','Asset');

if($person->world->existsAugmentation) {
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/augmentation','Augmentation');
}

if($person->world->existsBionic) {
    $component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/bionic','Bionic');
}

$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/consumable','Consumable');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/description','Description');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/experience','Experience');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/expertise','Expertise');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/milestone','Milestone');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/protection','Protection');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/skill','Skill');

if($person->world->existsSoftware) {
    //$component->linkButton('/play/' . $person->id . '/' . $person->hash . '/edit/software', 'Software');
}

if($person->isSupernatural) {
    $component->linkButton('/play/' . $person->id . '/' . $person->hash . '/edit/supernatural', 'Supernatural');
}

$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/edit/weapon','Weapon');
$component->linkButton('/play/'.$person->id.'/'.$person->hash.'/cheat','Cheat',true);

$component->wrapEnd();
?>