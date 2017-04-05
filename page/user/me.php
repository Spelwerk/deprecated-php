<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 19:00
 */
global $user, $component;
?>

<?php
$component->title($user->displayname);
print_r($user);
?>
