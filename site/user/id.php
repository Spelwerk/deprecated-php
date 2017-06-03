<?php global $component, $curl, $sitemap, $user;

$id = is_numeric($sitemap->index) && is_int($sitemap->index + 0) ? intval($sitemap->index) : $sitemap->index;

$account = $curl->get('user/id/'.$id)['data'][0];

$component->title($account['displayname']);
?>