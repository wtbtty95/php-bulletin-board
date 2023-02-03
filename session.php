<?php
session_start();
if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	require('db_connect.php');
	$sql = 'select * from members where mail = :mail and pass = :pass';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($data === false) {
		$result = '登録がありません';
	} else {
		$result = 'OK';
		$_SESSION['id'] = $data['id'];
		$_SESSION['name'] = $data['name'];
	}
	$dbh = null;
} else {
	$result = '全て入力してください';
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
if ($result == 'OK'):
	header('Location: ./posts_list.php');
else:
	echo $result;
?>
<p><a href="login.php">ログイン画面へ戻る</a></p>
<?php endif; ?>
</body>
</html>
