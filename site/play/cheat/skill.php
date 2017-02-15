<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:05
 */
global $sitemap, $form;
$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

?>

<script src="/js/play.js"></script>

<h2>Edit Skills</h2>
<?php $system->makeSkillPurchase($person, 999); ?>