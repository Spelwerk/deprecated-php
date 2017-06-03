<?php global $component, $sitemap, $user;

$component->title('Login');

if($user->id) {
    $component->h1('Already Logged In');
    $component->subtitle('You are already logged in. If you wish to create a new account you will have to log out first.');

    require_once('./site/user/logout/logout.php');
} else {
    switch($sitemap->index) {
        default:
            require_once('./site/user/login/password.php');
            break;

        case 'email':
            require_once('./site/user/login/email.php');
            break;

        case 'verify':
            require_once('./site/user/login/verify.php');
            break;
    }
}
?>