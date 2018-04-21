<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title>群組列表</title>
</head>
<body>
<?php
try {
	$db = new PDO('mysql:host=localhost;dbname=exam;charset=utf8'
		, 'root', '', array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		));
} catch (PDOException $err) {
	echo "ERROR:";
	echo $err->getMessage(); //真實世界不這樣做
	exit;
}
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '<a href="sign_in.html">登入</a>&nbsp&nbsp&nbsp';
	echo '<a href="sign_up.html">註冊</a>';
} else {
	$stmt = $db->prepare('select * from account where user_id=?');
	$stmt->execute([$_GET['uid']]);
	$row = $stmt->fetch();
	echo $row['name'] . '歡迎!!&nbsp';
	echo '<a href="group_list.php">登出</a><br>';
	if ($row['author']) {
		echo '<a href="add_group_form.html">新建群組</a>&nbsp&nbsp&nbsp';
		echo '<a href="management.php?uid=' . $_GET['uid'] . '">管理</a>';
	}
}
$stmt = $db->prepare('select * from group_list');
$stmt->execute();
echo '<table border=1>';
while ($row = $stmt->fetch()) {
	echo '<tr>';
	echo '<td>';
	if (!isset($_GET['uid']) || empty($_GET['uid'])) {
		echo '<a href="topic.php?gid=' . $row['group_id'] . '">' . $row['name'] . '</a>';
	} else {
		echo '<a href="topic.php?gid=' . $row['group_id'] . '&uid=' . $_GET['uid'] . '">' . $row['name'] . '</a>';
	}
	echo '</td>';
	echo '</tr>';
}
echo '</table>';
?>
</body>
</html>