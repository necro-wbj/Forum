<?php
if (!isset($_POST['id']) || !isset($_POST['name'])
	|| empty($_POST['id']) || empty($_POST['name'])) {
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
echo $_POST['id'];
echo '<br>';
$stmt = $db->prepare('insert into topic(group_id,name) values(?,?)');
$stmt->execute([$_POST['id'], $_POST['name']]);
header('Location:topic.php?id=' . $_POST['id'] . '', true, 303)
?>
