<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 15:06
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
$component->h2('Edit Skills');
$system->person_purchaseDiscipline($person, 999, true);
?>

<script src="/js/play_create.js"></script>
