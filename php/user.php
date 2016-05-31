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
<div class="container-fluid">
<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
include_once('conn.php');
include_once('nongli.php');
if(!empty($_SESSION['admin']))
{
    if (!empty($_POST['insert']))
    {
        $count=$_POST['count'];
        $classid=$_POST['classid'];
        $name=$_POST['name'];
        $depart=$_POST['depart'];
        $birthday=$_POST['birthday'];
        $isnongli=$_POST['isnongli'];
        $class=$_POST['class'];
        $onweek=$_POST['onweek'];
        $ontime=$_POST['ontime'];
        // var_dump($_POST);
        $select_user_sql="select * from users where classid='$classid'";
        $select_user_qurey=mysqli_query($con,$select_user_sql);
        $select_user_array=mysqli_fetch_array($select_user_qurey);
        if ($isnongli==1)
        {
            $lunar = new Lunar();
            $birthday=date("Y-m-d",$lunar->S2L($birthday));
        }
        if (empty($select_user_array))
        {
          $sql="insert into users(classid,name,depart,birthday,class,isnongli) values('$classid','$name','$depart','$birthday','$class','$isnongli');";
          mysqli_query($con,$sql)or die('插入用户失败');
        }
        for($i=0;$i<$count;$i++)
        {
          $select_userdutys_sql="select * from user_dutys where classid='$classid' and onweek='".$onweek["$i"]."' and ontime='".$ontime["$i"]."';";
          $select_userdutys_qurey=mysqli_query($con,$select_userdutys_sql);
          $select_userdutys_array=mysqli_fetch_array($select_userdutys_qurey);
          // var_dump($select_userdutys_array);
          if(empty($select_userdutys_array))
          {
            $sql_2="insert into user_dutys(classid,onweek,ontime) values('$classid','$onweek[$i]','$ontime[$i]');";
            mysqli_query($con,$sql_2)or die('插入值班时间失败');
            echo "插入".$onweek["$i"].",".$ontime["$i"]."的值班记录成功<br />";
          }else{
            echo "有".$onweek["$i"].",".$ontime["$i"]."的值班记录了<br />";
          }
        }
        echo "插入完成";
    }
    else if(!empty($_POST['update']))
    {
        $count=$_POST['count'];
        $id=$_POST['id'];
        $classid=$_POST['classid'];
        $name=$_POST['name'];
        $depart=$_POST['depart'];
        $birthday=$_POST['birthday'];
        $isnongli=$_POST['isnongli'];
        $class=$_POST['class'];
        $onweek=$_POST['onweek'];
        $ontime=$_POST['ontime'];
        if ($isnongli==1)
        {
            $lunar = new Lunar();
            $birthday=date("Y-m-d",$lunar->S2L($birthday));
        }
        // var_dump($_POST);

            $update_user="update users set classid='$classid',name='$name',depart='$depart',birthday='$birthday',class='$class',isnongli='$isnongli' where id='$id'";
            mysqli_query($con,$update_user)or die("失败");
            $delete_user_dutys="delete from user_dutys where classid='$classid'";
            mysqli_query($con,$delete_user_dutys);
        for ($i=0; $i<$count; $i++) {
          if($onweek[$i]!=0 && $ontime[$i]!=0)
          {
            $new_user_dutys="insert into user_dutys(classid,onweek,ontime) value('$classid','$onweek[$i]','$ontime[$i]')";
            mysqli_query($con,$new_user_dutys);
            header("location:user.php?classid=$classid");
          }
        }
    }
    else if(!empty($_GET['classid']))
    {
      $classid=$_GET['classid'];
      $select_update_user="select * from `users` where `users`.`classid`='$classid'";
      $select_update_user_query=mysqli_query($con,$select_update_user);
      $select_update_user_array=mysqli_fetch_array($select_update_user_query);
      // var_dump($select_update_user_array);
      $select_count="select count(*) from user_dutys where classid='$classid'";
      $select_count_query=mysqli_query($con,$select_count);
      $select_count_array=mysqli_fetch_array($select_count_query);
?>

    <form method="post" class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" action="user.php" name="user" id="form" onsubmit="return InputCheck(this)">
      <div class="form-group">
        <label>学号</label>
        <input type="hidden" name="count" id="count" value="<?php echo $select_count_array[0];?>">
        <input type="hidden" name="id" value="<?php echo $select_update_user_array['id'];?>">
        <input type="text" name="classid" class="form-control" value="<?php echo $classid;?>">
      </div>
      <div class="form-group">
        <label>姓名</label>
        <input type="text" name="name" class="form-control" value="<?php echo $select_update_user_array['name'];?>">
      </div>
      <div class="form-group">
        <label>部门</label>
        <input type="text" name="depart" class="form-control" value="<?php echo $select_update_user_array['depart'];?>">
      </div>
      <div class="form-group">
        <label>生日</label>
        <label><span class="text-danger">#日期一律填公历，程序会自动转化</span></label><br />
        <label><span class="text-danger">#选择过农历生日的，更新前显示的是农历</span></label>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <input type="text" name="birthday" value="<?php echo $select_update_user_array['birthday'];?>" class="form-control">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <select name="isnongli" class="form-control">
                    <option value="0">过公历生日</option>
                    <option value="1">过农历生日</option>
                </select>
            </div>
        </div>
      </div>
    <?php
    $gangwei=array("试用","正式","退站");
    $select_user_dutys="select * from user_dutys where classid='$classid'";
    $select_user_dutys_query=mysqli_query($con,$select_user_dutys);
    ?>
        <div class="form-group">
          <label>岗位</label>
          <select name="class" class="form-control">
              <option value="0" <?php if ($select_update_user_array['class']==0) echo "selected = \"selected\""?>>试用</option>
              <option value="1" <?php if ($select_update_user_array['class']==1) echo "selected = \"selected\""?>>正式</option>
          </select>
        </div>
          <?php
            $x=0;
            while($select_user_dutys_array=mysqli_fetch_array($select_user_dutys_query))
            {
                $x++;
          ?>
        <div class="form-group">
          <div>
            <label>值班时间(<?php echo $x;?>)<span class="text-danger">#填0，则删除这次值班</span></label>
          </div>
          <div class="col-xs-6">
            <input type="text" name="onweek[]" class="form-control" placeholder="1,2,3,4,5,6,7" value="<?php echo $select_user_dutys_array['onweek'];?>">
          </div>
          <div class="col-xs-6">
            <input type="text" name="ontime[]" class="form-control" placeholder="12,34,56,78,910" value="<?php echo $select_user_dutys_array['ontime'];?>">
          </div>
        </div>
          <?php
            }
          ?>
        <div class="form-group" id="add_duty">
          <botton type="submit" class="btn btn-primary" onclick="javascript:add();">添加值班</botton>
        </div>
        <input type="submit" class="btn btn-default" value="更新" name="update"/>
        <a href="../index.php"><input class="btn btn-success" value="返回首页"></a>
      </form>

    <?php
    }
    else
    {
    ?>
      <form method="post" class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" action="user.php" name="user" id="form" onsubmit="return InputCheck(this)">
        <div class="form-group">
          <label>学号</label>
          <input type="hidden" name="count" id="count" value="2"><!--判断安排值班的时间，初始值为1，从0开始计数-->
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
          <div class="row">
              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" name="birthday" placeholder="1994-04-02" class="form-control">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <select name="isnongli" class="form-control">
                      <option value="0">过公历生日</option>
                      <option value="1">过农历生日</option>
                  </select>
              </div>
          </div>
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
            <input type="text" name="onweek[]" placeholder="1,2,3,4,5,6,7" class="form-control">
          </div>
          <div class="col-xs-6">
            <input type="text" name="ontime[]" placeholder="12,34,56,78,910" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <div>
            <label>值班时间(2)</label>
          </div>
          <div class="col-xs-6">
            <input type="text" name="onweek[]" placeholder="1,2,3,4,5,6,7" class="form-control">
          </div>
          <div class="col-xs-6">
            <input type="text" name="ontime[]" placeholder="12,34,56,78,910" class="form-control">
          </div>
        </div>
        <div class="form-group" id="add_duty">
          <botton type="submit" class="btn btn-primary" onclick="javascript:add();">添加值班</botton>
        </div>
        <input type="submit" class="btn btn-default" value="添加" name="insert"/>
        <a href="../index.php"><input class="btn btn-success" value="返回首页"></a>
      </form>
    <?php
    }
    ?>
      <script type="text/javascript">
            var count=$("#count").val();
            function add(){
              count++;
              var newdiv="<div><label for=\"exampleInput\">值班时间("+count+")</label></div><div class=\"col-xs-6\"><input type=\"text\" name=\"onweek[]\" placeholder=\"1,2,3,4,5,6,7\" class=\"form-control\"></div><div class=\"col-xs-6\"><input type=\"text\" name=\"ontime[]\" placeholder=\"12,34,56,78,910\" class=\"form-control\"></div>";
              $("#add_duty").before(newdiv);
              $("#count").val(count);
            }
            function InputCheck(user)
            {
              //获取form标签元素
              var form=document.getElementById('form');
              //获取form下元素下所有input标签
              var inputArray=form.getElementsByTagName("input");
              var inputArrayLength=inputArray.length;
              //循环input元素数组
              for(var int=0;int<inputArrayLength;++int){
                  //判断每个input元素的值是否为空
                  if((inputArray[int].value==null || inputArray[int].value=='')&&int!=4){
                      // alert('第'+(int)+'个input的值为空.');
                      switch(int)
                      {
                        case 1:
                          alert("学号不能为空！");
                          return false;
                          break;
                        case 2:
                          alert("姓名不能为空！");
                          return false;
                          break;
                        case 3:
                          alert("部门不能为空！");
                          return false;
                          break;
                        default:
                          alert("值班时间不能为空");
                          return false;
                          break;
                      }
                      
                  }
              }
              //如果所有Input标签的值都不为空的话
              return true;
            }
      </script>
<?php
}else{
echo "没有登录，无法使用该功能";
}?>
</div>
</body>
</html>