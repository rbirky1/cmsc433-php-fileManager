<?
$fn = $_GET['name'];
$fm = $_GET['mime'];
$f = "/home/csee1/rbirky1/www-data/read-write/fm/$fn";

define("FILE", "/home/csee1/rbirky1/www-data/read-write/fm/$fn");

header("Content-type: $fm");

print (file_get_contents(FILE));

?>
