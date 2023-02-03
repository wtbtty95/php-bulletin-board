<?php
#$upload_dir = 'images/';
$file_name = ($_FILES['image']['tmp_name']);
#$upload_file = $upload_dir . $file_name;
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $file_name);
finfo_close($finfo);
echo $mime_type;

#pathinfoで拡張子を取得(PATHINFO_EXTENSIONで最後の拡張子だけ取得）
/*$file_type = pathinfo($upload_file, PATHINFO_EXTENSION);
require('db_connect.php');
if (!empty($_FILES['image']['name'])) {
	$allow_types = array('jpg', 'png', 'jpeg');
if (in_array($file_type, $allow_types)) {
		if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
			$sql = 'insert into members (image_name) values ($file_name)';
			$result = $dbh->query($sql);
			if ($result) {
				$msg = '完了しました';
			} else {
				$msg = '失敗しました';
			}
		} else {
			$msg = 'ファイルのアップロードに失敗しました';
		}
	} else {
		$msg = 'アップロード可能なファイルは、JPG,PNG,JPEGのみです';
	}
} else {
	$msg = 'アップロードするファイルを選択してください';
}
echo $msg;
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>検証</title>
</head>
<body>
<h3>ファイル送信</h3>
<form method="POST" enctype="multipart/form-data">
<input type="file" name="image">
<p><input type="text" name="comment"></p>
<input type="submit" value="送信" name="upload">
</form>
</body>
</html>
