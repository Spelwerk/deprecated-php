<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 18:51
 */
global $sitemap, $form;
$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();
?>

<script src="/js/play.js"></script>

<h2>Purchase Skill</h2>
<?php
$exp = $person->getAttribute(null, $person->world->experience)[0];
$system->person_purchaseSkill($person, $exp->value);
?>