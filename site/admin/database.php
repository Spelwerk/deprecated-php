<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 01/02/2017
 * Time: 14:43
 */
global $form, $sitemap;

require_once('./class/Admin.php');

$admin = new Admin();

$GET_TABLE = isset($_GET['table']) ? $_GET['table'] : 'world';
?>

<h2>Table Add</h2>
<?php
$form->genericStart();
$admin->makeAdd($GET_TABLE);
$form->genericEnd();
?>

<h2>Table Edit</h2>
<?php
$form->genericStart();
$admin->makeEdit($GET_TABLE, 1);
$form->genericEnd();
?>

<h2>Table View</h2>
<?php $admin->makeTable($GET_TABLE); ?>