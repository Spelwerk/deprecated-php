<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 08:27
 */
global $user, $form;
?>

<?php
if($user) {
    $userData = $user->getPerson();

    $form->printPerson($userData, 'Your Persons');
}
?>

<?php
if(isset($_COOKIE['sw_person_list'])) {
    $cookieData = unserialize($_COOKIE['sw_person_list']);

    $form->printPerson($cookieData, 'Saved Locally');
}
?>

<?php if(!$user && !isset($_COOKIE['sw_person_list'])): ?>
    <h2>Empty</h2>
<?php endif; ?>

<div class="sw-l-content__wrap">
    <a class="sw-c-link" href="/play">Create New</a>
</div>

