<?php
session_start();
if (!empty($_SESSION['id'])) {
	require('db_connect.php');
	if (!empty($_GET['id']) && empty($_POST['id'])) {
		$id = filter_input(INPUT_GET, 'id');
		$sql1 = 'select * from members where id = :id';
		$stmt1 = $dbh->prepare($sql1);
		$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt1->execute();
		$data = $stmt1->fetch(PDO::FETCH_ASSOC);
		if ($data['id'] !== $_SESSION['id']) {
			header('Location: ./posts_list.php');
		}
	} elseif (!empty($_POST['id'])) {
		$id = filter_input(INPUT_POST, 'id');
		$sql1 = 'select * from members where id = :id';
		$stmt1 = $dbh->prepare($sql1);
		$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt1->execute();
		$data = $stmt1->fetch(PDO::FETCH_ASSOC);
		if ($data['id'] !== $_SESSION['id']) {
			header('Location: ./posts_list.php');
		} else {
			if (!empty($_FILES['image']['tmp_name'])) {
				$file = $_FILES['image'];
				$file_name = basename($file['name']);
				$tmp_path = $file['tmp_name'];
				$upload_dir = 'images/';
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime_type = finfo_file($finfo, $tmp_path);
				finfo_close($finfo);
				switch (strtolower($mime_type)) {
					case 'image/jpg':
						$ext = 'jpg';
						break;
					case 'image/jpeg':
						$ext = 'jpeg';
						break;
					case 'image/png':
						$ext = 'png';
						break;
					default:
						$ext = $mime_type;
				}
				$allow_ext = array('jpg', 'jpeg', 'png');
				if (!in_array($ext, $allow_ext)) {
					$error = 'アップロードできるのはjpg,jpeg,pngのみです';
				} else {
					$save_file_name = uniqid(mt_rand()) . '.' . $ext;
					if (move_uploaded_file($tmp_path, $upload_dir . $save_file_name)) {
						$image_name = $save_file_name;
						if ($data['image_name'] !== '未登録' && !empty($data['image_name'])) {
							unlink($upload_dir . $data['image_name']);
						}
					} else {
						$error = 'ファイルがアップできませんでした';
					}
				}
			} else {
				if ($data['image_name']) {
					$image_name = $data['image_name'];
				} else {
					$image_name = '未登録';
				}
			}
			if (!empty($_POST['comment'])) {
				$comment = filter_input(INPUT_POST, 'comment');
			} else {
				$comment = null;
			}
			if (empty($error)) {
				$sql2 = 'update members set comment = :comment, image_name = :image_name where id = :id';
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->bindParam(':comment', $comment, PDO::PARAM_STR);
				$stmt2->bindParam(':image_name', $image_name, PDO::PARAM_STR);
				$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt2->execute();
				$result ='更新しました';
			}
		}
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
<h1>ユーザー情報更新</h1>
<?php if (!empty($error)): ?>
<p><?= $error; ?></p>
<p><a href="admin_edit.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">編集画面へ</a></p>
<?php elseif (!empty($result)): ?>
<p><?= $result; ?></p>
<?php else: ?>
<form method="POST" enctype="multipart/form-data">
アップロード画像<p>
<input type="file" name="image">
</p>
一言コメント<p><textarea name="comment" rows="4"><?= $data['comment']; ?></textarea></p>
<p><input type="submit" value="更新する" name="update"></p>
<?php
?>
<input type="hidden" name="id" value="<?= $data['id']; ?>">
</form>
<?php endif; ?>
<p><a href="admin.php?id=<?= htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">ユーザー情報画面へ戻る</a></p>
</body>
</html>
