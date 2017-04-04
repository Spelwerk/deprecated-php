<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 29/03/2017
 * Time: 14:24
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

$component->title('Edit '.$person->nickname);
?>

<div class="sw-l-quicklink">
    <?php $component->linkQuick('/play/'.$person->id.'/'.$person->hash,'Return','/img/return.png'); ?>
</div>

<?php
$list = $person->getMilestone();

$component->wrapStart();
$component->h2('Milestone');

if(isset($list)) {
    foreach($list as $item) {
        $person->buildRemoval($item->id, $item->name, $item->icon, 'weapon');
    }
}

$component->wrapEnd();

?>

<script src="/js/play_create.js"></script>
