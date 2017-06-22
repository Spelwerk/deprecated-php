<?php
require_once('../class/Post.php');

$post = new Post();

$data = ['secret' => $_GET['s']];

$post->curl->userSet('user/login/verify', $data);

$post->redirect($post->returnBase);
?>

<a href="<?php echo $post->returnBase; ?>"><?php echo $post->returnBase; ?></a>

