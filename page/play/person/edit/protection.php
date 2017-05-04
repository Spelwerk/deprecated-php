<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 19:16
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');

$person = new Person($sitemap->id, $sitemap->hash);

$component->title('Edit '.$person->nickname);

if($person->isOwner) {
    $component->returnButton($person->siteLink);

    $component->h2('Protection');

    if($sitemap->context == 'add') {
        $person->postProtection();
    } else {
        if(isset($list)) {
            foreach($list as $item) {
                $person->buildRemoval('protection', $item->id, $item->name, $item->icon);
            }
        }

        $component->linkButton($person->siteLink.'/edit/protection/add','Add');
    }
}
?>

<script src="/js/validation.js"></script>
