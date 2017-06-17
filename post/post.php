<?php
require_once('../class/Post.php');

$post = new Post();

$post->switchTop();

$post->redirect($post->getReturn());
?>

<h2>Data</h2>
<?php print_r($post->data); ?>
<h2>Return</h2>
<a href="<?php echo $post->getReturn(); ?>"><?php echo $post->getReturn(); ?></a>
