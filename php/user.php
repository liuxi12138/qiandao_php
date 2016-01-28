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
<?php
header("Content-Type: text/html;charset=utf-8");
include('conn.php');

if (!empty($_POST['insert']))
{
  $classid=$_POST['classid'];
  $name=$_POST['name'];
  $depart=$_POST['depart'];
  $birthday=$_POST['birthday'];
  $ondutys=$_POST['ondutys'];
  $sql="insert into users(id,classid,name,depart,birthday,ondutys) values('','$classid','$name','$depart','$birthday','$ondutys');";
  mysqli_query($con,$sql)or die('插入失败');
}else{
?>
<div class="container-fluid">
  <form method="post" action="user.php">
    <div class="form-group">
      <label for="exampleInput">学号</label>
      <input type="text" name="classid" class="form-control">
    </div>
    <div class="form-group">
      <label for="exampleInput">姓名</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group">
      <label for="exampleInput">部门</label>
      <input type="text" name="depart" class="form-control">
    </div>
    <div class="form-group">
      <label for="exampleInput">生日</label>
      <input type="text" name="birthday" class="form-control">
    </div>
    <div class="form-group">
      <label for="exampleInput">值班时间</label>
      <input type="text" name="ondutys" class="form-control">
    </div>
    <input type="submit" class="btn btn-default" value="submit" name="insert"/>
  </form>
</div>
<?php
}
?>
</body>
</html>