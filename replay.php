<!DOCTYPE html>
<html lang="zh_Hant">
<head>
	<meta charset="utf-8">
	<title>回覆</title>
</head>
<body>
<?php
if (!isset($_GET['mid']) || empty($_GET['mid']) ||
	!isset($_GET['uid']) || empty($_GET['uid'])) {
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
	exit;
}
$stmt = $db->prepare('select * from message where message_id=?');
$stmt->execute([$_GET['mid']]);
$row = $stmt->fetch();
echo $row['message'];
?>
	<form method="POST" action="add_message.php">
<input type="hidden" name="name" value="<?php $stmt = $db->prepare('select * from account where user_id=?');
$stmt->execute([$_GET['uid']]);
$row2 = $stmt->fetch();
echo $row2['name'] . '--->' . $row['name'];?>">
	<input type="hidden" name="mid" value="<?php echo $_GET['mid']; ?>">
	<input type="hidden" name="mid" value="<?php echo $_GET['mid']; ?>">
	<input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">
	<input type="hidden" name="gid" value="<?php echo $_GET['gid']; ?>">
	<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
	請輸入回覆:<input type="text" name="message">
	<input type="submit">
	</form>
	<a href="message.php?tid=<?php echo $_GET['tid'] . '&gid=' . $_GET['gid'] . '&uid=' . $_GET['uid']; ?>">取消留言<a>
</body>
</html>
