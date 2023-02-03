<?php
$file = $_FILES['image'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'images/';
$save_filename = date('YmdHis') . $filename;
$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($comment)) {
	echo '入力してください';
} else {
	echo $comment;
}
//拡張子は画像か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
//strtolower →小文字に変換してくれる（jpgとか大文字の場合があるから）
echo '画像ファイルを添付してください';
}
#テンポラリーファイルに保存されていればアップロードされたということ
if (is_uploaded_file($tmp_path)) {
	if (move_uploaded_file($tmp_path, $upload_dir . $save_filename)) {
		if (exif_imagetype($save_filename)) {
			echo 'ok';
		}
		echo $filename . 'を' . $upload_dir . 'にアップしました';
	} else {
		echo 'ファイルが保存できませんでした。';
	}
} else {
	echo 'ファイルが選択されていません';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題１８</title>
</head>
<body>
<h1>ファイル送信</h1>
<form method="POST" enctype="multipart/form-data">
<p><input type="file" name="image"></p>
<p><input type="text" name="comment"></p>
<input type="submit" value="送信" name="upload">
</form>
</body>
</html>
