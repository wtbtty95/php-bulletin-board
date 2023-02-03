<?php
if (!empty($_POST['mail'])) {
	$mail = filter_input(INPUT_POST, 'mail');
	if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		require('db_connect.php');
		$sql = 'select * from members where mail = :mail';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			$url = 'https://procir-study.site/watabe474/main/task19/password_reset_url.php?key=';
			$reset_key = uniqid(mt_rand());
			$subject = 'パスワード再設定について';
			$message = 'こちらのリンクからパスワードの再設定を行なってください:';
			$message .= $url . $reset_key;
			$headers = 'From: a@a.com';
			mb_language('japanese');
			mb_internal_encoding('UTF-8');
			if (mb_send_mail($mail, $subject, $message, $headers)) {
				$result = 'メールを送信しました。記載されたパスワード再発行用URLから、３０分以内に新規パスワードを設定してください。';
				$reset_date = date('Y-m-d H:i:s');
				$sql = 'update members set reset_date = :reset_date, reset_key = :reset_key where mail = :mail';
				$stmt = $dbh->prepare($sql);
				$stmt->bindParam(':reset_date', $reset_date, PDO::PARAM_STR);
				$stmt->bindParam(':reset_key', $reset_key, PDO::PARAM_STR);
				$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
				$stmt->execute();
			}
		} else {
			$result = 'メールを送信しました。記載されたパスワード再発行用URLから、３０分以内に新規パスワードを設定してください。';
		}
		$dbh = null;
	} else {
		$result = 'メールアドレスを入力してください';
	}
} else {
	$result = 'メールアドレスを入力してください';
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
<p><a href="password_reset.php">パスワード再発行申請画面へ</a></p>
<?php else: ?>
<h1>パスワード再発行申請画面</h1>
<p>登録しているメールアドレスを入力してください</p>
<form method="POST">
<p><input type="email" name="mail"></p>
<input type="submit" name="submit" value="送信">
</form>
<?php endif; ?>
<p><a href="login.php">ログイン画面へ</a></p>
</body>
</html>
