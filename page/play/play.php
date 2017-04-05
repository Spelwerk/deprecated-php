<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 04/04/2017
 * Time: 22:31
 */
global $component;

$component->title('Play');
$component->linkAction('/play/person','Persons','A person, or a character, is what you use to play the game.','/img/add-person.png');
$component->linkAction('/play/story','Stories','Create your Story and use it to connect your friends together.','/img/add-story.png');
$component->linkAction('/play/companion','Companions','A person can have a companion. Create and share.','/img/add-companion.png');
?>