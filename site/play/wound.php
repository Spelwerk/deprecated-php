<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 08:08
 */
global $form, $sitemap;
?>
<div class="sw-l-quicklink">
    <a class="sw-l-quicklink__item" href="/play/<?php echo $person->id; ?>/<?php echo $person->hash; ?>"><img src="/img/return.png"/></a>
</div>

<script src="/js/validation.js"></script>

<h2>Add Wound</h2>

<?php
$form->genericStart();
$form->getHidden('post', 'return', 'play');
$form->getHidden('post', 'returnid', 'wound');
$form->getHidden('post', 'do', 'wound--add');
$form->getHidden('post', 'id', $sitemap->id);
$form->getHidden('post', 'hash', $sitemap->hash);

$form->getVarchar('wound', 'name', true);
$form->getBool('wound', 'lethal', true);

$form->genericEnd();
?>

