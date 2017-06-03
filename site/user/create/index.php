<?php global $component, $sitemap, $user;

$component->title('Create User');

switch($sitemap->index) {
    default:
        require_once('./site/user/create/create.php');
        break;

    case 'timeout':
        require_once('./site/user/create/timeout.php');
        break;

    case 'verify':
        require_once('./site/user/create/verify.php');
        break;
}
?>