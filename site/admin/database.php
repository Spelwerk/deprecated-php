<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 01/02/2017
 * Time: 14:43
 */

$GET_TABLE = isset($_GET['table']) ? $_GET['table'] : 'world';
?>

<h2>Table Add</h2>

<?php
global $admin;
$admin->makeAdd($GET_TABLE);
?>

<h2>Table Edit</h2>

<?php
global $admin;
$admin->makeEdit($GET_TABLE, 1);
?>

<h2>Table View</h2>

<?php
global $admin;
$admin->makeTable($GET_TABLE);
?>