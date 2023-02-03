<?php
session_start();
if (!empty($_SESSION['id']) && !empty($_SESSION['name'])) {
	header('Location: ./posts_list.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<h1>会員登録画面</h1>
<form action="insert.php" method="POST">
名前を入力してください<p><input type="text" name="name"></p>
メールアドレスを入力してください<p><input type="email" name="mail"></p>
パスワードを入力してください<p><input type="password" minlength="10" maxlength="20" name="pass"></p>
<p><input type="submit" value="登録する"></p>
<p><a href="login.php">登録がお済みの方はこちらへ</a></p>
</form>
</body>
</html>
