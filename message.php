<?php
if (!isset($_GET['tid']) || empty($_GET['tid']) ||
	!isset($_GET['gid']) || empty($_GET['gid'])) {
	echo '參數不正確';
	// echo '<a href="add_form.html">重新輸入</a>';
	exit;
}
//連接資料庫
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
?>
<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title>
	<?php
$stmt = $db->prepare('select * from topic where topic_id=?');
$stmt->execute([$_GET['tid']]);
while ($row = $stmt->fetch()) {
//小心,此處的=號是把右邊的值存往左側
	echo $row['name'];}
?>
</title>
<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
</head>
<body>
<?php
//查詢
//等同 $stmt = $db->query('select name,cost from moneybook');
$stmt = $db->prepare('select * from account where user_id=?');
$stmt->execute([$_GET['uid']]);
$row2 = $stmt->fetch();
$stmt = $db->prepare('select message_id,message.topic_id,message.name,message,group_id from message,topic where topic.topic_id=? AND topic.topic_id=message.topic_id;');
$stmt->execute([$_GET['tid']]);
while ($row = $stmt->fetch()) {
//小心,此處的=號是把右邊的值存往左側
	echo $row['name'];
	echo "：";
	echo $row['message'];
	if (isset($_GET['uid']) || !empty($_GET['uid'])) {
		if ($row2['author']) {
			echo '&nbsp|&nbsp<a href="delete_message.php?mid=' . $row['message_id'] . '&uid=' . $_GET['uid'] . '&gid=' . $_GET['gid'] . '&tid=' . $_GET['tid'] . '">刪除</a>&nbsp|&nbsp';
			echo '<a href="replay.php?mid=' . $row['message_id'] . '&uid=' . $_GET['uid'] . '&gid=' . $_GET['gid'] . '&tid=' . $_GET['tid'] . '">回覆</a>';
		}
	}
	echo '<br>';
}
echo '<br>';
?>
	<form method="POST" action="add_message.php">
	<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
	<input type="hidden" name="gid" value="<?php echo $_GET['gid']; ?>">
	<?php
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '請輸入暱稱:<input type="text" name="name">';
} else {
	echo '<input type="hidden" name="uid" value="' . $_GET['uid'] . '">';
	$stmt = $db->prepare('select * from account where user_id=?');
	$stmt->execute([$_GET['uid']]);
	$row2 = $stmt->fetch();
	echo '<input type="hidden" name="name" value="' . $row2['name'] . '">';
}
?>
	請輸入留言:<input type="text" name="message">
	<input type="submit">
	</form>
<?php
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '<a href="topic.php?gid=' . $_GET['gid'] . '">返回主題列表</a>';
} else {
	echo '<a href="topic.php?gid=' . $_GET['gid'] . '&uid=' . $_GET['uid'] . '">返回主題列表</a>';
}
?>
</body>
</html>