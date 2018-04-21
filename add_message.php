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
	echo '<a href="add_form.html">重新輸入</a>';
	exit;
}
$stmt = $db->prepare('insert into message (name,message,topic_id) values (?,?,?);');
$stmt->execute([$_POST['name'], $_POST['message'], $_POST['tid']]);
if (!isset($_POST['uid']) || empty($_POST['uid'])) {
	header('Location:message.php?uid=' . $_GET['uid'] . '&gid=' . $_POST['gid'] . '', true, 303);
} else {
	header('Location:message.php?uid=' . $_GET['uid'] . '&gid=' . $_POST['gid'] . '&uid=' . $_POST['uid'] . '', true, 303);
}
?>