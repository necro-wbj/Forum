<?php
if (!isset($_GET['tid']) || empty($_GET['tid']) ||
	!isset($_GET['gid']) || empty($_GET['gid'])) {
	echo '參數不正確';
	// echo '<a href="add_form.html">重新輸入</a>';
	exit();
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
<style type="text/css">
	.transparent{
    	background-color: transparent; border: 0;
	}
 </style>
<script language="javascript">
var emoji_array = new Array("&#x1F600;","&#x1F601;","&#x1F602;") ;
function input_emoji(str){
	var t=document.getElementById(messages).value;
	document.getElementById(messages).value=t+str;
}
function display(str){
	document.getElementById(str).innerHTML=str;
}
function add_emoji() {
	var i=0;
	for(i=0;i<emoji_array.length;i++){
				var I=document.createElement("button");
				I.setAttribute("class","transparent");
				I.setAttribute("value",emoji_array[i]);
				I.setAttribute("onclick","input_emoji('"+emoji_array[i]+"')");
				I.setAttribute("id",emoji_array[i]);
                document.getElementById("emoji").appendChild(I);
                display(emoji_array[i]);

	}
}
function input_emoji(str) {
	t=document.getElementById("message").value
	document.getElementById("message").value=t+str;
	remove_emoji()
}
function remove_emoji(){
	var i;
	for(i=0;i<emoji_array.length;i++){
		document.getElementById("emoji").removeChild(document.getElementById(emoji_array[i]));
	}
}
</script>
</head>
<body>
<?php
//查詢
//等同 $stmt = $db->query('select name,cost from moneybook');
if (isset($_GET['uid']) || !empty($_GET['uid'])) {
	$stmt = $db->prepare('select * from account where user_id=?');
	$stmt->execute([$_GET['uid']]);
	$row2 = $stmt->fetch();
}
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
	請輸入留言:<input type="text" name="message" id="message">
	<input type="button" value="&#x1F600;" onclick="add_emoji()" class="transparent"  >
	<input type="submit" >
	</form>

<?php
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
	echo '<a href="topic.php?gid=' . $_GET['gid'] . '">返回主題列表</a>';
} else {
	echo '<a href="topic.php?gid=' . $_GET['gid'] . '&uid=' . $_GET['uid'] . '">返回主題列表</a>';
}
?>
<div id="emoji"></div>
</body></html>