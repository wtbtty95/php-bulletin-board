<?php
session_start();
if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])) {
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	require('db_connect.php');
	$sql = 'select * from members where mail = :mail';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($data === false) {
		$sql = 'insert into members (name, mail, pass) values (:name, :mail, :pass)';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		$stmt->execute();
		$result = '登録が完了しました';
	} else {
		$result = '同じメールアドレスでは登録できません';
	}
	$dbh = null;
} else {
	$result = '未入力の箇所があります';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<?php
if ($result == '登録が完了しました'):
	echo $result;
?>
<p><a href="login.php">ログインする</a></p>
<?php
else:
	echo $result;
?>
<p><a href="signup.php">登録画面へ戻る</a></p>
<?php endif; ?>
</body>
</html>
