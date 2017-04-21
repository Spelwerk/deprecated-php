<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 05/04/2017
 * Time: 09:13
 */
global $user, $component, $curl, $cookieArray;

$component->title('Story');
$component->linkAction('/play/story/new','Create Story','Text about stories.','/img/link-story-w.png');

$userList = $user->isActive
    ? $user->getPerson()
    : null;

$cookieList = isset($_COOKIE[$cookieArray['story']])
    ? unserialize($_COOKIE[$cookieArray['story']])
    : null;

$filterList = null;

if($userList) {
    $component->h1('Your saved stories');

    foreach($userList as $item) {
        if(isset($item['story_id'])) {
            $filterList[] = $item['story_id'];

            $isOwner = isset($item['story_hash'])
                ? true
                : false;

            $link = $isOwner
                ? 'play/story/id/'.$item['story_id'].'/'.$item['story_hash']
                : 'play/story/id/'.$item['story_id'];

            $story = $curl->get('story/id/'.$item['story_id'])['data'][0];

            $component->linkButton($link,$story['name']);
        }
    }
}

if($cookieList) {
    $component->h1('Stories found in cookies');

    foreach($cookieList as $item) {
        if($filterList && in_array($item['story_id'],$filterList)) {}
        else {
            if(isset($item['story_id'])) {
                $filterList[] = $item['story_id'];

                $isOwner = isset($item['story_hash'])
                    ? true
                    : false;

                $link = $isOwner
                    ? '/play/story/id/'.$item['story_id'].'/'.$item['story_hash']
                    : '/play/story/id/'.$item['story_id'];

                $story = $curl->get('story/id/'.$item['story_id'])['data'][0];

                $component->linkButton($link,$story['name']);
            }
        }
    }
}


?>