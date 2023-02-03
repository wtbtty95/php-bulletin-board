<?php
if (!empty($_GET['key']) &!empty($_POST['pass'])) {
	require('db_connect.php');
	$reset_key = $_GET['key'];
	$pass = filter_input(INPUT_POST, 'pass');
	$date = new DateTime('- 30 min');
	$access_date = $date->format('Y-m-d H:i:s');
	$sql = 'select * from members where reset_key = :reset_key and reset_date >= :access_date';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':reset_key', $reset_key, PDO::PARAM_STR);
	$stmt->bindParam(':access_date', $access_date, PDO::PARAM_STR);
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($data) {
		$id = $data['id'];
		$sql = 'update members set pass = :pass, reset_key = null where id = :id';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = 'パスワードの更新が完了しました';
	} else {
		$result = '不正なアクセスです。再度お試しください。';
	}
	$dbh = null;
} else {
	$result = 'パスワードを入力してください';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<?php if (!empty($_POST['submit'])): ?>
<?= $result; ?>
<?php if ($result === '不正なアクセスです。再度お試しください。'): ?>
<p> <a href="password_reset.php">パスワード再発行申請画面へ</a></p>
<?php elseif ($result === 'パスワードを入力してください'): ?>
<p><a href="passwprd_reset_url.php?key=<?= htmlspecialchars($reset_key, ENT_QUOTES, 'UTF-8'); ?>">パスワードを再度入力する</a></p>
<?php elseif ($result === 'パスワードの更新が完了しました'): ?>
<p><a href="login.php">ログイン画面へ</a></p>
<?php endif; ?>
<?php else: ?>
<form method="POST">
<h1> 新しいパスワードを入力してください</h1>
<input type="password" minlength="10" maxlength="20" name="pass">
<input type="submit" name="submit" value="更新">
</form>
<?php endif; ?>
</body>
</html>
