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
			if (empty($_POST['title']) || trim($_POST['title']) == '') {
				$errors[] = 'タイトルを入力してください';
			}
			if (empty($_POST['text']) || trim($_POST['text']) == '') {
				$errors[] = '本文を入力してください';
			}
			if (empty($errors)) {
				$title = $_POST['title'];
				$text = $_POST['text'];
				$sql = 'update posts set title = :title, text = :text where id = :id';
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':text', $text, PDO::PARAM_STR);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
				header('Location: ./posts_list.php');
			}
		}
		$dbh = null;
	}
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
<h1>投稿内容編集ページ</h1>
<?php
if (!empty($errors)):
	foreach ($errors as $error):
?>
<p><?= $error; ?></p>
<?php endforeach; ?>
<?php endif; ?>
<form method="POST">
<?php
if (!empty($data['title'])):
	$result_title = $data['title'];
elseif (!empty($_POST['title'])):
	$result_title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
endif;
?>
<p>投稿タイトル</p>
<p><input type="text" name="title" value="<?= $result_title; ?>"</p>
<?php
if (!empty($data['text'])):
	$result_text = $data['text'];
elseif (!empty($_POST['text'])):
	$result_text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
endif;
?>
<p>本文</p>
<p><textarea name="text" rows="4"><?= $result_text; ?></textarea></p>
<p><input type="submit" value="更新する"></p>
<?php
if (!empty($data['id'])):
	$result_id = $data['id'];
elseif (!empty($_POST['id'])):
	$result_id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
endif;
?>
<input type="hidden" name="id" value="<?= $result_id; ?>">
</form>
<p><a href="posts_list.php">戻る</a></p>
</body>
</html>
