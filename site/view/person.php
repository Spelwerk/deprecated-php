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
$userData = null;

if($user) {
    $userData = $user->getPerson();

    $idList = null;

    if($userData != null) {
        foreach($userData as $p) {
            $idList[] = $p['person_id'];
        }

        $form->printPerson($userData, 'Your Persons');
    }
}

if(isset($_COOKIE['sw_person_list'])) {
    $cookieData = unserialize($_COOKIE['sw_person_list']);

    foreach($cookieData as $key => $c) {
        if($userData != null && in_array($c['person_id'], $idList)) {
            unset($cookieData[$key]);
        }
    }

    if(count($cookieData) >= 1) {
        $form->printPerson($cookieData, 'Saved Locally');
    }
}
?>

<?php if(!$user && !isset($_COOKIE['sw_person_list'])): ?>
    <h2>Empty</h2>
<?php endif; ?>

<div class="sw-l-content__wrap">
    <a class="sw-c-link" href="/play">Create New</a>
</div>

