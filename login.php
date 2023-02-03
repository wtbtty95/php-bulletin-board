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
<?php
if (!empty($_SESSION['id']) && !empty($_SESSION['name'])):
	echo $_SESSION['name'] . 'さんがログイン済みです';
?>
<p><a href="logout.php">ログアウトする</a></p>
<?php else: ?>
<h1>ログイン画面</h1>
<form action="session.php" method="POST">
メールアドレスを入力してください<p><input type="email" name="mail"></p>
パスワードを入力してください<p><input type="password" name="pass"></p>
<p><input type="submit" value="ログイン"></p>
<p><a href="signup.php">新規会員登録はこちら</a></p>
<p><a href="password_reset.php">パスワードを忘れた方はこちら</a></p>
</form>
<?php endif; ?>
</body>
</html>
