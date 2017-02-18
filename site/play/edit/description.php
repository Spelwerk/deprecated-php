<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 16/02/2017
 * Time: 20:00
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

<h2>Description</h2>
<form action="/post.php" method="post">
    <?php
    $form->getHidden('post', 'return', 'play');
    $form->getHidden('post', 'do', 'person--put');
    $form->getHidden('post', 'id', $person->id);
    $form->getHidden('post', 'hash', $person->hash);

    $form->getVarchar('person', 'nickname', false, $person->nickname);

    $form->getVarchar('person', 'firstname', false, $person->firstname);
    $form->getVarchar('person', 'surname', false, $person->surname);
    $form->getVarchar('person', 'gender', false, $person->gender);

    $form->getNumber('person', 'age', false, 0, $person->species->maxAge, $person->age);

    $form->getText('person', 'description', false, $person->description);
    $form->getText('person', 'behaviour', false, $person->behaviour);
    $form->getText('person', 'appearance', false, $person->appearance);
    $form->getText('person', 'features', false, $person->features);
    $form->getText('person', 'personality', false, $person->personality);
    ?>
    <input class="sw-c-submit sw-js-submit sw-is-clickable" type="submit" value="Next &raquo;"/>
</form>
