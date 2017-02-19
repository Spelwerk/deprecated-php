<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 08:27
 */
global $user, $form;

$userData = null;
$cookieName = 'sw_person_list';

if($user) {
    $userData = $user->getPerson();

    $idList = null;

    if($userData != null) {
        foreach($userData as $item) {
            $idList[] = $item['person_id'];

            echo(
                '<h3>Your Persons</h3>'.
                '<div class="sw-l-table">'
            );

            $form->printTableRow($item['nickname'], '/play/', $item['person_id'], $item['person_hash']);

            echo('<div>');
        }
    }
}

if(isset($_COOKIE[$cookieName])) {
    $cookieData = unserialize($_COOKIE[$cookieName]);

    foreach($cookieData as $key => $c) {
        if($userData != null && in_array($c['person_id'], $idList)) {
            unset($cookieData[$key]);
        }
    }

    if(count($cookieData) >= 1) {
        echo(
            '<h3>Persons found in cookie</h3>'.
            '<div class="sw-l-table">'
        );

        foreach($cookieData as $item) {
            $form->printTableRow($item['name'], '/play/', $item['person_id'], $item['person_hash']);
        }

        echo('<div>');
    }
}
?>

<?php if(!$user && !isset($_COOKIE[$cookieName])): ?>
    <h2>Empty</h2>
<?php endif; ?>

<div class="sw-l-content__wrap">
    <a class="sw-c-link" href="/play">Create New</a>
</div>

