<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 29/03/2017
 * Time: 14:24
 */
global $sitemap, $form;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();
?>

<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<h2>Milestone</h2>
<?php
$list = $person->getMilestone();

foreach($list as $item) {
    $person->buildEditDescription($item->id, $item->name, $item->description, $item->icon, 'milestone');
}
?>