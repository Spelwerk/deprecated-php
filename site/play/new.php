<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 10:55
 */

$Form = new Form();

?>

<h2>World Select</h2>

<form>
<?php
$System->setWorldList();
$Form->radio('world--1',$System->worldList);
$Form->select('world--2',$System->worldList);
?>
</form>
