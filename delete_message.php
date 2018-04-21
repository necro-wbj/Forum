<?php
if (!isset($_GET['mid']) || empty($_GET['mid']) ||
	!isset($_GET['uid']) || empty($_GET['uid'])) {
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
$stmt = $db->prepare('delete from message where message_id=?');
$stmt->execute([$_GET['mid']]);
header('Location:message.php?tid=' . $_GET['tid'] . '&gid=' . $_GET['gid'] . '&uid=' . $_GET['uid'] . '', true, 303)
?>