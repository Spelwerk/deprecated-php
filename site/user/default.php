<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 12/02/2017
 * Time: 14:11
 */

global $user;
?>

<?php if($user != null): ?>

    <h2><?php echo $user->username ?></h2>

    <!-- end -->

    <a class="sw-c-link" href="/user/edit">EDIT PROFILE</a>

    <form action="/post.php" method="post">
        <input type="hidden" name="user--email" value="<?php echo $user->email ?>"/>
        <input type="hidden" name="post--do" value="user--reset"/>
        <input type="hidden" name="post--return" value="user/password"/>
        <input class="sw-c-link sw-js-submit" type="submit" value="SET PASSWORD"/>
    </form>

    <form action="/post.php" method="post">
        <input type="hidden" name="post--do" value="user--logout"/>
        <input type="hidden" name="post--return" value="user/login"/>
        <input class="sw-c-link sw-c-link--dangerous sw-js-submit" type="submit" value="LOGOUT"/>
    </form>

<?php endif; ?>

