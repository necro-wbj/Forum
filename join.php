<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title>註冊帳號</title>
</head>
<body>
<?php
if (!isset($_POST['name']) || empty($_POST['name']) ||
	!isset($_POST['password']) || empty($_POST['password'])) {
	echo '參數不正確';
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
$stmt = $db->prepare('insert into account(name,pw) values(?,?)');
$stmt->execute([$_POST['name'], $_POST['password']]);
header('Location:group_list.php', true, 303);
?>
</body>
</html>