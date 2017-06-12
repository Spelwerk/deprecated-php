<?php
require_once('../class/Post.php');

$post = new Post();

$post->switchTop();

$post->redirect($post->returnFull);
?>

<a href="<?php echo $post->returnFull; ?>"><?php echo $post->returnFull; ?></a>
