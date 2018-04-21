<?php
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '錯誤!';
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
$stmt = $db->prepare('select * from account');
$stmt->execute();
while ($row = $stmt->fetch()) {
	if (!$row['author']) {
		echo $row['user_id'] . '：' . $row['name'] . '<a href="add_management.php?uid=' . $_GET['uid'] . '&pid=' . $row['user_id'] . '">變更為管理員</a>&nbsp&nbsp&nbsp';

	} else {
		echo $row['user_id'] . '：' . $row['name'] . '<a href="delete_management.php?uid=' . $_GET['uid'] . '&pid=' . $row['user_id'] . '">變更為普通帳號</a>&nbsp&nbsp&nbsp';
	}
	echo '<a href="delete_account.php?uid=' . $_GET['uid'] . '&pid=' . $row['user_id'] . '">刪除帳號</a>';
	echo '<br>';
}
echo '<a href="index.php?uid=' . $_GET['uid'] . '"></a>'
?>