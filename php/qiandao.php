<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');
if(!empty($_GET['classid']))
{
	$classid=$_GET['classid'];
	$ceshitime=time();
	$date=date("Y-m-d");
	$time=date("H:i:s");
	$week=date("N");
	$aorp=date("a");
	$select_user="select * from users where classid=$classid";
	$user_query=mysqli_query($con,$select_user);
	$user_array=mysqli_fetch_array($user_query);
	// var_dump($user_array);
	if (empty($user_array))
	{
		$data['fankui']="nouser";
		echo json_encode($data);
	}
	else
	{
		echo $date;
		echo $time;
		$select_over="select * from dutys where classid='$classid' and date='$date';";
		$over_query=mysqli_query($con,$select_over);
		$over_array=mysqli_fetch_array($over_query);
		var_dump($over_array);
		// if ($over_array['over']==1||empty($over_array))
		// {
		// 	$sql="insert into dutys(id,classid,date,stime,etime,aorp,week,early,over) values('','$classid','$date','$time','','$aorp','$week','',0)";
		// 	mysqli_query($con,$sql)or die('插入失败');
		// 	$data['fankui']="success1";
		// 	echo json_encode($data);
		// }
		// else if($over_array['over']==0)
		// {
		// 	$sql="update dutys set etime='$time',over=1 where classid='$classid' and over=0";
		// 	mysqli_query($con,$sql)or die('更新失败');
		// 	$data['fankui']="success2";
		// 	echo json_encode($data);
		// }
	}
}
// echo date("Y-m-d")."+++".date("H:i:s")."+++".date("N");
