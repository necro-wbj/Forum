<?php
if (!isset($_GET['gid']) || empty($_GET['gid'])) {
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
?>
<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title><?php
$stmt = $db->prepare('select * from group_list where group_id=?');
$stmt->execute([$_GET['gid']]);
$row = $stmt->fetch();
echo $row['name'];
?></title>
</head>
<body>
<?php
$stmt = $db->prepare('select * from topic where group_id=?');
$stmt->execute([$_GET['gid']]);
while ($row = $stmt->fetch()) {
	if (!isset($_GET['uid']) || empty($_GET['uid'])) {
		echo '<a href="message.php?tid=' . $row['topic_id'] . "&gid=" . $_GET['gid'] . '">' . $row['name'] . '</a>';

	} else {
		echo '<a href="message.php?tid=' . $row['topic_id'] . "&gid=" . $_GET['gid'] . '&uid=' . $_GET['uid'] . '">' . $row['name'] . '</a>';
	}
	echo '<br>';
}
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '<a href="index.php">返回群組列表</a>';
	echo "&nbsp&nbsp";
} else {
	echo '<a href="index.php?&uid=' . $_GET['uid'] . '">返回群組列表</a>';
	$stmt = $db->prepare('select * from account where user_id=?');
	$stmt->execute([$_GET['uid']]);
	$row = $stmt->fetch();
	if ($row['author']) {
		echo "&nbsp";
		echo '<a href="add_topic_form.php?gid=' . $_GET['gid'] . '&uid=' . $_GET['uid'] . '">新增主題</a>';
	}
}
?>
</body>
</html>
