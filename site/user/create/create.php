<?php global $form, $component, $user, $sitemap;

if($user->id) {
    $component->h1('Already Logged In');
    $component->subtitle('You are already logged in. If you wish to create a new account you will have to log out first.');

    require_once('./site/user/logout/logout.php');
} else {
    $component->wrapStart();
    $form->form([
        'special' => 'user',
        'do' => 'post',
        'return' => 'user'
    ]);
    $form->email(true,'email','Email','This will be kept secret and protected, and you will use it to login.');
    $form->submit(true,'Create');
    $component->wrapEnd();
}
?>