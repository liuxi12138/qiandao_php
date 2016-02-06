<?php
include('conn.php');
header("Content-Type: text/html;charset=utf-8");
if(!empty($_POST['delete_shiyong']))
{
	var_dump($_POST['user_array']);
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
	$gangwei=array("试用","正式");
	$sql="select * from users";
	$query=mysqli_query($con,$sql);
	while($array=mysqli_fetch_array($query))
	{
		echo "<tr>";
		echo "<td><input type=\"checkbox\" id=\"user_array[]\" name=\"user_array[]\" value=\"$array[id]\"  onclick=\"setSelectAll();\"></td>";
		echo "<td>".$array['name']."</td>";
		echo "<td>".$array['depart']."</td>";
		echo "<td>".$array['birthday']."</td>";
		echo "<td>".$gangwei[$array['class']]."</td>";
		echo "</tr>";
	}
	?>
	</table>
	<input type="submit" name="delete_shiyong" class="btn btn-danger" value="删除选定的试用成员">
	<input type="submit" name="delete_zhengshi" class="btn btn-danger" value="正式成员的退站">
	<input type="submit" name="delete_all" class="btn btn-danger" value="清空值班表及成员名单">
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
?>