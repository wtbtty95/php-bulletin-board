<?php
session_start();
if (!empty($_SESSION['id'])) {
	require('db_connect.php');
	if (!empty($_GET['id']) && empty($_POST['id'])) {
		$id = $_GET['id'];
		$sql = 'select * from posts where id = :id and delete_flag = 0';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($data) || $data['member_id'] !== $_SESSION['id']) {
			header('Location: ./posts_list.php');
		}
	} elseif (!empty($_POST['id'])) {
		$id = $_POST['id'];
		$sql = 'select * from posts where id = :id and delete_flag = 0';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($data) || $data['member_id'] !== $_SESSION['id']) {
			header('Location: ./posts_list.php');
		} else {
			$sql = 'update posts set delete_flag = 1 where id = :id';
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			header('Location: ./posts_list.php');
		}
	}
	$dbh = null;
} else {
	header('Location: ./login.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<h1>投稿内容削除ページ</h1>
<form method="POST">
<p>以下の投稿を削除します。よろしいですか？</p>
投稿タイトル<p><input type="text" name="title" value="<?= htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8'); ?>" disabled></p>
本文<p><textarea name="text" rows="4" disabled><?= htmlspecialchars($data['text'], ENT_QUOTES, 'UTF-8'); ?></textarea></p>
<p><input type="submit" value="削除する"></p>
<input type="hidden" name="id" value="<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">
</form>
<p><a href="posts_list.php">戻る</a></p>
</body>
</html>
