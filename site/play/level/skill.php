<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
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

<script src="/js/play.js"></script>

<h2>Purchase Skill</h2>
<?php
$exp = $person->getAttribute(null, $person->world->experience)[0];
$system->person_purchaseSkill($person, $exp->value);
?>