<?php
session_start();
include('conn.php');
header("Content-Type: text/html;charset=utf-8");
if(!empty($_SESSION['admin']))
{
	if(!empty($_POST['delete_shiyong']))
	{
		// var_dump($_POST['user_array']);
		$user_array=$_POST['user_array'];
		// var_dump($user_array);
		$num = count($user_array);
		for($i=0;$i<$num;$i++){ 
			// echo $user_array[$i].'<br />'; 
			$select_user="select * from `users` where id='$user_array[$i]'";
			$select_user_query=mysqli_query($con,$select_user) or die ('select失败');
			$select_user_array=mysqli_fetch_array($select_user_query);

			$delete_shiyong_duty="delete from `dutys` where classid='$select_user_array[classid]'";
			mysqli_query($con,$delete_shiyong_duty) or die('dutys失败');
			$delete_shiyong_userduty="delete from `user_dutys` where classid='$select_user_array[classid]'";
			mysqli_query($con,$delete_shiyong_userduty) or die('user_dutys失败');

			$delete_shiyong="delete from `users` where id='$user_array[$i]'";
			mysqli_query($con,$delete_shiyong) or die('users失败');
		}
		echo "清删除试用成员值班记录、值班表、用户信息<br><a href=\"user_table.php\">返回继续管理</a><br><a href=\"../index.php\">返回首页</a>";
	}
	else if(!empty($_POST['delete_zhengshi']))
	{
		$user_array=$_POST['user_array'];
		$num = count($user_array);
		for($i=0;$i<$num;$i++){
			$select_user="select * from `users` where id='$user_array[$i]'";
			$select_user_query=mysqli_query($con,$select_user) or die ('select失败');
			$select_user_array=mysqli_fetch_array($select_user_query);

			$delete_zhengshi_dutys="delete from `dutys` where classid='$select_user_array[classid]';";
			mysqli_query($con,$delete_zhengshi_dutys) or die('dutys失败');
			$delete_zhengshi_userduty="delete from `user_dutys` where classid='$select_user_array[classid]'";
			mysqli_query($con,$delete_zhengshi_userduty) or die('user_dutys失败');

			$update_zhengshi_tuizhan="update `users` set class=2 where classid='$select_user_array[classid]'";
			mysqli_query($con,$update_zhengshi_tuizhan) or die('update失败');
		}
		echo "删除退站成员值班表和值班记录，保留用户信息<br><a href=\"user_table.php\">返回继续管理</a><br><a href=\"../index.php\">返回首页</a>";
	}
	else if(!empty($_POST['delete_stoz']))
	{
		$user_array=$_POST['user_array'];
		$num = count($user_array);
		for($i=0;$i<$num;$i++){
			$select_user="select * from `users` where id='$user_array[$i]'";
			$select_user_query=mysqli_query($con,$select_user) or die ('select失败');
			$select_user_array=mysqli_fetch_array($select_user_query);

			$delete_zhengshi_dutys="delete from `dutys` where classid='$select_user_array[classid]';";
			mysqli_query($con,$delete_zhengshi_dutys) or die('dutys失败');
			$delete_zhengshi_userduty="delete from `user_dutys` where classid='$select_user_array[classid]'";
			mysqli_query($con,$delete_zhengshi_userduty) or die('user_dutys失败');

			$update_zhengshi_tuizhan="update `users` set class=1 where classid='$select_user_array[classid]'";
			mysqli_query($con,$update_zhengshi_tuizhan) or die('update失败');
		}
		echo "已经改成正式成员<br><a href=\"user_table.php\">返回继续管理</a><br><a href=\"../index.php\">返回首页</a>";
	}
	else
	{
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>用户管理</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<script type="text/javascript" src="../js/avalon.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
	</head>
	<body>
	<form method="post" action="user_table.php">
		<table class="table table-striped">
			<tr>
				<td><input type="checkbox" id="selAll" onclick="selectAll();">全选</td>
				<td>姓名</td>
				<td>部门</td>
				<td>生日</td>
				<td>(试用/正式)</td>
			</tr>
		<?php
		$gangwei=array("试用","正式","退站");
		$sql="select * from users where class=0 or class=1";
		$query=mysqli_query($con,$sql) or die('delete');
		while($array=mysqli_fetch_array($query))
		{
			echo "<tr>";
			echo "<td><input type=\"checkbox\" id=\"user_array[]\" name=\"user_array[]\" value=\"$array[id]\"  onclick=\"setSelectAll();\"></td>";
			echo "<td><a href=\"user.php?classid=".$array['classid']."\">".$array['name']."</a></td>";
			echo "<td>".$array['depart']."</td>";
			echo "<td>".$array['birthday']."</td>";
			echo "<td>".$gangwei[$array['class']]."</td>";
			echo "</tr>";
		}
		?>
		</table>
		<?php

		?>
		<input type="submit" name="delete_shiyong" class="btn btn-danger" value="删除选定的试用成员">
		<input type="submit" name="delete_stoz" class="btn btn-danger" value="已经被确定正式">
		<input type="submit" name="delete_zhengshi" class="btn btn-danger" value="正式成员的退站">
		<a href="user.php"><input class="btn btn-success" value="添加值班人员"></a>
		<a href="../index.php"><input class="btn btn-success" value="返回首页"></a>
	</form>
	<script language="javascript"> 
	//选中全选按钮，下面的checkbox全部选中 
	var selAll = document.getElementById("selAll"); 
	function selectAll() 
	{ 
		var obj = document.getElementsByName("user_array[]"); 
		if(document.getElementById("selAll").checked == false)
			for(var i=0; i<obj.length; i++)
				obj[i].checked=false;
		else
			for(var i=0; i<obj.length; i++)
				obj[i].checked=true;
	}
	//当选中所有的时候，全选按钮会勾上 
	function setSelectAll() 
	{ 
	var obj=document.getElementsByName("user_array[]"); 
	var count = obj.length; 
	var selectCount = 0; 

		for(var i = 0; i < count; i++)
			if(obj[i].checked == true)
				selectCount++;
		if(count == selectCount)
			document.all.selAll.checked = true;
		else
			document.all.selAll.checked = false;
	}
	</script>
	</body>
	</html>
<?php
	}
}else{
	echo "未登录，无法使用该功能";
}
?>