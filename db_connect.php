<?php
try {
	$dbh = new PDO('mysql:host=localhost;dbname=tatsuya_db;charset=utf8', 'watabe474', 'w8wi80ozrm');
} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
?>
