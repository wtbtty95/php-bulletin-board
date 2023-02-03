<?php
session_start();
if (!empty($_SESSION['id'])) {
	$id = $_SESSION['id'];
	if (!empty($_POST['title']) && !empty($_POST['text']) && trim($_POST['title']) !== '' && trim($_POST['text']) !== '') {
		$time = date('Y-m-d H:i:s');
		$title = $_POST['title'];
		$text = $_POST['text'];
		require('db_connect.php');
		$sql = 'insert into posts (member_id, title, text, post_date_time, delete_flag) values (:id, :title, :text, :post_date_time, 0)';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':text', $text, PDO::PARAM_STR);
		$stmt->bindParam(':post_date_time', $time, PDO::PARAM_STR);
		$stmt->execute();
		$result = '投稿しました';
		$dbh = null;
	} else {
		$result = '全て入力してください';
	}
} else {
	header('Location: ./signup.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<?= $result; ?>
<h1>投稿フォーム</h1>
<form  method="POST">
投稿タイトル<p><input type="text" name="title"></p>
本文<p><textarea name="text" rows="4"></textarea></p>
<p><input type="submit" value="投稿する" name="post"></p>
<p><a href="posts_list.php">投稿一覧へ</a></p>
</form>
</body>
</html>
