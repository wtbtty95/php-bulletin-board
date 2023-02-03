<?php
session_start();
if (!empty($_SESSION['id'])) {
		$id = filter_input(INPUT_GET, 'id');
		require('db_connect.php');
		$sql = 'select * from members where id = :id';
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
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
<h1>ユーザー情報</h1>
<?php if ($_SESSION['id'] === $id): ?>
<p><a href="admin_edit.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">編集</a></p>
<?php endif; ?>
<table>
<tr>
<th>ユーザー名</th>
<th>ユーザー画像</th>
<th>メールアドレス</th>
<th>一言コメント</th>
</tr>
<tr>
<td><?= $data['name']; ?></td>
<?php if ($data['image_name'] == '未登録'): ?>
<td><?= $data['image_name']; ?></td>
<?php elseif ($data['image_name'] == null): ?>
<td><?= '未登録'; ?></td>
<?php else: ?>
<td><img src="images/<?= $data['image_name']; ?>"</td>
<?php endif; ?>
<td><?= $data['mail']; ?></td>
<td><?= $data['comment']; ?></td>
</tr>
</table>
<p><a href="posts_list.php">投稿一覧へ</a></p>
</body>
</html>
