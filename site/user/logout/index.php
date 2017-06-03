<?php global $form, $component, $sitemap, $user;

$component->title('Logout');

if($user->id) {
    require_once('./site/user/logout/logout.php');
}
?>