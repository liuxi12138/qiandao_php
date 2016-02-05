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
    $count=$_POST['count'];
    $classid=$_POST['classid'];
    $name=$_POST['name'];
    $depart=$_POST['depart'];
    $birthday=$_POST['birthday'];
    $class=$_POST['class'];
    $onweek=$_POST['onweek'];
    $ontime=$_POST['ontime'];
    // var_dump($_POST);
    $select_user_sql="select * from users where classid='$classid'";
    $select_user_qurey=mysqli_query($con,$select_user_sql);
    $select_user_array=mysqli_fetch_array($select_user_qurey);
    if (empty($select_user_array))
    {
      $sql="insert into users(id,classid,name,depart,birthday,class) values('','$classid','$name','$depart','$birthday','$class');";
      mysqli_query($con,$sql)or die('插入用户失败');
    }
    for($i=1;$i<=$count;$i++)
    {
      $select_userdutys_sql="select * from user_dutys where classid='$classid' and onweek='".$onweek["$i"]."' and ontime='".$ontime["$i"]."';";
      $select_userdutys_qurey=mysqli_query($con,$select_userdutys_sql);
      $select_userdutys_array=mysqli_fetch_array($select_userdutys_qurey);
      // var_dump($select_userdutys_array);
      if(empty($select_userdutys_array))
      {
        $sql_2="insert into user_dutys(id,classid,onweek,ontime) values('','$classid','$onweek[$i]','$ontime[$i]');";
        mysqli_query($con,$sql_2)or die('插入值班时间失败');
        echo "插入".$onweek["$i"].",".$ontime["$i"]."的值班记录成功<br />";
      }else{
        echo "有".$onweek["$i"].",".$ontime["$i"]."的值班记录了<br />";
      }
    }
    echo "插入成功";
}else{
?>
<div class="container-fluid">
  <form method="post" action="user.php">
    <div class="form-group">
      <label>学号</label>
      <input type="hidden" name="count" id="count" value="2">
      <input type="text" name="classid" class="form-control">
    </div>
    <div class="form-group">
      <label>姓名</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group">
      <label>部门</label>
      <input type="text" name="depart" class="form-control">
    </div>
    <div class="form-group">
      <label>生日</label>
      <input type="text" name="birthday" class="form-control">
    </div>
    <div class="form-group">
      <label>岗位</label>
      <select name="class" class="form-control">
        <option value="0">试用</option>
        <option value="1">正式</option>
      </select>
    </div>
    <div class="form-group">
      <div>
        <label>值班时间(1)</label>
      </div>
      <div class="col-xs-6">
        <input type="text" name="onweek[1]" class="form-control">
      </div>
      <div class="col-xs-6">
        <input type="text" name="ontime[1]" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <div>
        <label>值班时间(2)</label>
      </div>
      <div class="col-xs-6">
        <input type="text" name="onweek[2]" class="form-control">
      </div>
      <div class="col-xs-6">
        <input type="text" name="ontime[2]" class="form-control">
      </div>
    </div>
    <script type="text/javascript">
        var count=2;
        function add(){
          count++;
          var newdiv="<div><label for=\"exampleInput\">值班时间("+count+")</label></div><div class=\"col-xs-6\"><input type=\"text\" name=\"onweek["+count+"]\" class=\"form-control\"></div><div class=\"col-xs-6\"><input type=\"text\" name=\"ontime["+count+"]\" class=\"form-control\"></div>";
          $("#add_duty").before(newdiv);
          $("#count").val(count);
        }
    </script>
    <div class="form-group" id="add_duty">
      <botton type="submit" class="btn btn-primary" onclick="javascript:add();">添加值班</botton>
    </div>
    <input type="submit" class="btn btn-default" value="submit" name="insert"/>
  </form>
</div>
<?php
}
?>
</body>
</html>