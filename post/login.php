<?php
require_once('../class/Post.php');

$post = new Post();

$post->data = ['secret' => $_GET['s']];

$post->userSet('user/login/verify');

$post->redirect($post->returnBase);
?>

<a href="<?php echo $post->returnFull; ?>"><?php echo $post->returnFull; ?></a>

