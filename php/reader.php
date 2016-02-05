<?php
error_reporting(E_ERROR);
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include("conn.php");
if(!empty($_FILES['file_stu']['tmp_name'])&&is_uploaded_file($_FILES['file_stu']['tmp_name'])){ 
	$file_stu=$_FILES["file_stu"]; 
	//获取数组里面的值 
	$filename=$file_stu["name"];//上传文件的文件名 
	$filetype=$file_stu["type"];//上传文件的类型 
	$filesize=$file_stu["size"];//上传文件的大小 
	$tmp_name=$file_stu["tmp_name"];//上传文件的临时存放路径 
	if ($filetype!="application/vnd.ms-excel")
	{
		echo "上传的文件不是csv文件，请重新上传";
	}
	else
	{
		$error=$file_stu["error"];//上传后系统返回的值 
		echo "================<br/>"; 
		echo "上传文件名称是：".$filename."<br/>"; 
		echo "上传文件类型是：".$filetype."<br/>"; 
		echo "上传文件大小是：".$filesize."<br/>"; 
		echo "上传后系统返回的值是：".$error."<br/>"; 
		echo "上传文件的临时存放路径是：".$tmp_name."<br/>"; 
		echo "开始移动上传文件<br/>"; 
		//把上传的临时文件移动到up目录下面 
		move_uploaded_file($tmp_name,'csvfile/'.$filename); 
		echo "================<br/>"; 
		echo "上传信息：<br/>"; 
		if($error==0)
			echo "文件上传成功啦！<br />";
		// elseif ($error==1){ 
		// echo "超过了文件大小，在php.ini文件中设置"; 
		// }elseif ($error==2){ 
		// echo "超过了文件的大小MAX_FILE_SIZE选项指定的值"; 
		// }elseif ($error==3){ 
		// echo "文件只有部分被上传"; 
		// }elseif ($error==4){ 
		// echo "没有文件被上传"; 
		// }else{ 
		// echo "上传文件大小为0"; 
		// } 

$file=fopen('csvfile/reader.csv','rb');
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
	}
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
        <input type="submit" name="upfile" value="导入" />
</form>
</body>
</html>
