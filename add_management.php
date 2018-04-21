<?php
if (!isset($_GET['uid']) || !isset($_GET['pid']) ||
	empty($_GET['uid']) || empty($_GET['pid'])) {
	echo '錯誤!!';
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
$stmt = $db->prepare('update account set author=1 where user_id=?');
$stmt->execute([$_GET['pid']]);
header('Location:management.php?uid=' . $_GET['uid'] . '', true, 303);

?>