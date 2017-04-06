<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 22:31
 */
global $user, $component, $curl;

$component->title('Person');
$component->linkAction('/play/person/add','Create Person','A person, or a character, is what you use to play the game.','/img/add-person.png');

$result = $curl->get('person/short',null,['order-by' => '{"popularity":"DESC", "thumbsup":"DESC", "nickname":"ASC"}', 'limit-from' => 5]);

$userList = $user->isActive
    ? $user->getPerson()
    : null;

$cookieList = isset($_COOKIE['sw_person_list'])
    ? unserialize($_COOKIE['sw_person_list'])
    : null;

$popularList = isset($result['data'])
    ? $result['data']
    : null;

$filterList = null;

if($userList) {
    $component->h1('Your saved persons');

    foreach($userList as $item) {
        if(isset($item['person_id'])) {
            $filterList[] = $item['person_id'];

            $isOwner = isset($item['person_hash'])
                ? true
                : false;

            $link = $isOwner
                ? 'play/person/id/'.$item['person_id'].'/'.$item['person_hash']
                : 'play/person/id/'.$item['person_id'];

            $person = $curl->get('person/short/id/'.$item['person_id'])['data'][0];

            $component->linkButton($link,$person['nickname'].' ('.$person['occupation'].') ('.$person['age'].')');
        }
    }
}

if($cookieList) {
    $component->h1('Persons found in cookies');

    foreach($cookieList as $item) {
        if($filterList && in_array($item['person_id'],$filterList)) {}
        else {
            if(isset($item['person_id'])) {
                $filterList[] = $item['person_id'];

                $isOwner = isset($item['person_hash'])
                    ? true
                    : false;

                $link = $isOwner
                    ? '/play/person/id/'.$item['person_id'].'/'.$item['person_hash']
                    : '/play/person/id/'.$item['person_id'];

                $person = $curl->get('person/short/id/'.$item['person_id'])['data'][0];

                $component->linkButton($link,$person['nickname'].' ('.$person['occupation'].') ('.$person['age'].')');
            }
        }
    }
}

$component->h1('Popular Persons');
foreach($popularList as $person) {
    if($filterList && in_array($person['id'],$filterList)) {}
    else {
        $component->linkButton('/play/person/id/'.$person['id'],$person['nickname'].' ('.$person['occupation'].') ('.$person['age'].')');
    }
}



/*

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
*/
?>