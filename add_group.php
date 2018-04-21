<?php
if (!isset($_POST['name']) || empty($_POST['name'])) {
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
//echo "連線成功";
$stmt = $db->prepare('insert into group_list (name) values (?)');
$stmt->execute([$_POST['name']]);
// echo '新增了';
// echo $stmt->rowCount();
// echo '筆資料';
header('Location:group_list.php', true, 303);
?>