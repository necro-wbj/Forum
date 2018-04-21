<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title>新建列表</title>
</head>
<body>
<?php
if (!isset($_POST['name']) || empty($_POST['name']) ||
	!isset($_POST['password']) || empty($_POST['password'])) {
	echo '參數不正確';
	// echo '<a href="add_form.html">重新輸入</a>';
	exit;
}
try {
	$db = new PDO('mysql:host=localhost;dbname=exam;charset=utf8'
		, 'root', '', array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		));
} catch (PDOException $err) {
	echo "ERROR:";
	echo $err->getMessage(); //真實世界不這樣做
	echo '<a href="add_form.html">重新輸入</a>';
	exit;
}
//echo "連線成功";
$stmt = $db->prepare('select * from account where name=? AND pw=?');
$stmt->execute([$_POST['name'], $_POST['password']]);
$row = $stmt->fetch();
if (!isset($row) || empty($row)) {
	echo '<script>';
	echo 'alert("帳號或密碼錯誤!");';
	echo 'document.location.href="sign_in.html";';
	echo '</script>';
} else {
	header('Location:group_list.php?uid=' . $row['user_id'] . '', true, 303);
}
?>
</body>
</html>