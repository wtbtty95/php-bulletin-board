<?php
session_start();
require('db_connect.php');
$sql = 'select members.name, posts.id, posts.member_id, posts.title, posts.text, posts.post_date_time from posts inner join members on posts.member_id = members.id where delete_flag = 0';
$results = $dbh->query($sql);
$dbh = null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１９</title>
</head>
<body>
<h1 align=center>投稿一覧</h1>
<p><a href="post.php">新規投稿する</a></p>
<?php if (!empty($_SESSION['id']) && !empty($_SESSION['name'])): ?>
<p align=right>
<?= $_SESSION['name'] . 'さんがログイン中'; ?>
<p align=right><a href="logout.php">ログアウトする</a></p>
<?php else: ?>
<p align=right>
<a href="signup.php">新規会員登録する</a>
<a href="login.php">ログインする</a>
</p>
<?php endif; ?>
<table border="1">
<tr>
<th>投稿ID</th>
<th>投稿者</th>
<th>タイトル</th>
<th>本文</th>
<th>投稿時間</th>
</tr>
<?php foreach ($results as $result): ?>
<tr>
<td><?= $result['id']; ?></td>
<td align=center>
<a href="admin.php?id=<?= htmlspecialchars($result['member_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= $result['name']; ?></a>
</td>
<td>
<?= $result['title']; ?>
<?php if (!empty($_SESSION['id'])): ?>
<?php if ($_SESSION['id'] === $result['member_id']): ?>
&emsp;<a href="edit.php?id=<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a>
<a href="delete.php?id=<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">削除</a>
<?php endif; ?>
<?php endif; ?>
</td>
<td align=center><?= $result['text']; ?></td>
<td><?= $result['post_date_time']; ?></td>
</tr>
<?php endforeach; ?>
</body>
</html>
