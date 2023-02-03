<?php
session_start();
$_SESSION = array();
setcookie('id', 'name', null);
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF=8">
<title>課題１９</title>
</head>
<body>
<p>ログアウトしました</p>
<p><a href="posts_list.php">投稿一覧へ</a></p>
<p><a href="login.php">ログインし直す</a></p>
</body>
</html>
