<?php
error_reporting(E_ERROR);
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include("conn.php");

require_once('Classes/PHPExcel.php');  
require_once('Classes/PHPExcel/Writer/Excel2007.php');
$file=fopen('reader.csv','rb');
$data=array();//fgetcsv — 从文件指针中读入一行并解析 CSV 字段
$row=0;
$field=array("classid","name","depart","birthday","class","onweek_all");
// $on_title=array("onweek","ontime");
while($line=fgetcsv($file))//一直取到文件结束，此事返回false
{
	foreach ($line as $key => $value) 
	{
		// $data[$row][$key]= iconv("utf-8","gb2312//IGNORE", $value);
		$data[$row][$field[$key]]=mb_convert_encoding($value,"utf-8","GBK");
		
	}
	$on=explode(",",$data[$row]['onweek_all']);
	// echo count($data[$row]['onweek']);
	for ($j=0;$j < count($on);$j++)
	{
		$on_title[$j]=explode("|",$on[$j]);
		$data[$row]["onweek"][$j]=$on_title[$j][0];
		$data[$row]["ontime"][$j]=$on_title[$j][1];
	}
	$row++;
}

// var_dump($data);
for ($x=1; $x<$row; $x++)
{
    $count=$j;
    $classid=$data[$x]['classid'];
    $name=$data[$x]['name'];
    $depart=$data[$x]['depart'];
    $birthday=$data[$x]['birthday'];
    // var_dump($data[$x]);
    if($data[$x]['class']=="试用")
    	$class=0;
    else if($data[$x]['class']=="正式")
    	$class=1;
    $onweek=$data[$x]['onweek'];
    $ontime=$data[$x]['ontime'];
    $select_user_sql="select * from users where classid='$classid'";
    $select_user_qurey=mysqli_query($con,$select_user_sql);
    $select_user_array=mysqli_fetch_array($select_user_qurey);
    if (empty($select_user_array))
    {
      $sql="insert into users(id,classid,name,depart,birthday,class) values('','$classid','$name','$depart','$birthday','$class');";
      mysqli_query($con,$sql)or die('插入用户失败');
      // echo $name."用户<br />";
    }
    // echo $name."用户<br />";
    // var_dump($data[$x]);
    // var_dump($onweek);
    for($i=0;$i<$count;$i++)
    {
		$select_userdutys_sql="select * from user_dutys where classid='$classid' and onweek='".$onweek["$i"]."' and ontime='".$ontime["$i"]."';";
		$select_userdutys_qurey=mysqli_query($con,$select_userdutys_sql);
		$select_userdutys_array=mysqli_fetch_array($select_userdutys_qurey);
		// echo $name."用户的".$onweek["$i"]."<br />";
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
    echo $name."插入成功<br />";
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>读取excel文件</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
        <h3>导入Excel表：</h3>
        <input  type="file" name="file_stu" />
        <input type="submit"  value="导入" />
</form>
</body>
</html>
