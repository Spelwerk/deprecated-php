<?php
require_once('../class/Post.php');

$post = new Post();

$post->switchTop();

//$post->redirect($post->getReturn());
?>

<a href="<?php echo $post->getReturn(); ?>"><?php echo $post->getReturn(); ?></a>
