<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');
if(!empty($_POST['classid']))
{
	$i=100;
	$classid=$_POST['classid'];
	// $classid=13110402096;
	$ceshitime=time();
	$date=date("Y-m-d");
	$time=date("H:i:s");
	$week=date("N");
	$aorp=date("a");
	$select_user="select * from users where classid=$classid";
	$user_query=mysqli_query($con,$select_user);
	$user_array=mysqli_fetch_array($user_query);
	switch($time)
	{
		case $time<='10:00:00':
			$ontime="12";
			break;
		case $time>'10:00:00'&&$time<='12:00:00':
			$ontime="34";
			break;
		case $time>'12:00:00'&&$time<='16:00:00':
			$ontime="56";
			break;
		case $time>'16:00:00'&&$time<='18:00:00':
			$ontime="78";
			break;
		case $time>'18:00:00':
			$ontime="910";
			break;
	}

	if (empty($user_array))
	{
		$data['fankui']="nouser";
		echo json_encode($data);
	}
	else
	{
		$select_over="select * from dutys where classid='$classid' and date='$date';";
		$over_query=mysqli_query($con,$select_over);
		$over_array=mysqli_fetch_array($over_query);
		if(empty($over_array))
			$i=0;//这一天没有签到记录
		else
		{	//今天有签到记录，是否已经签退需要继续判断
			$select_over="select * from dutys where classid='$classid' and date='$date' and over=0;";
			$over_query=mysqli_query($con,$select_over);
			$over_array=mysqli_fetch_array($over_query);
			if (empty($over_array))
			{
				//今天没有的未签退的记录
				$same_sql="select * from dutys where classid='$classid' and date='$date' and over=1;";
				$same_query=mysqli_query($con,$same_sql);
				while($same_array=mysqli_fetch_array($same_query))
				{
					if($ontime==$same_array['ontime'])
					{
						$same_ontime=$same_array['ontime'];
						$sql="update dutys set etime='$time' where classid='$classid' and ontime='$same_ontime' and over=1";
						mysqli_query($con,$sql);
						$i=2;
					}
					else
					{
						$i=0;
					}
				}
			}
			else
			{	//今天有未签退的记录
				$early_sql="select * from dutys where classid='$classid' and date='$date' and over=0;";
				$early_query=mysqli_query($con,$early_sql);
				$early_array=mysqli_fetch_array($early_query);
				$stime=$early_array['stime'];
				$time_cha=strtotime($time)-strtotime($stime);
				if($time_cha<=5400)
				{
					$i=3;//早退
				}
				else
				{
					$i=1;//本日存在签到记录
				}
			}
			// while ($over_array=mysqli_fetch_array($over_query))
			// {
			// 	// echo $over_array['over'];
			// 	// var_dump($over_array);
			// 	if($over_array['over']=='1'){
			// 		$i=0;//已经有过签退记录
			// 	}
			// 	else
			// 	{	//还没有签退记录
			// 		$early_sql="select * from dutys where classid='$classid' and date='$date' and over=0;";
			// 		$early_query=mysqli_query($con,$early_sql);
			// 		$early_array=mysqli_fetch_array($early_query);
			// 		$stime=$early_array['stime'];
			// 		$time_cha=strtotime($time)-strtotime($stime);
			// 		if($time_cha<=4200)
			// 		{
			// 			$i=3;//早退
			// 			// echo $i;
			// 		}
			// 		else
			// 		{
			// 			$i=1;//本日存在签到记录
			// 			// echo $i;
			// 		}
			// 	}
			// }
		}
		
		switch ($i) {
			case 0:
				$sql="insert into dutys(classid,date,stime,etime,aorp,week,early,over,ontime) values('$classid','$date','$time','$time','$aorp','$week',0,0,'$ontime')";
				mysqli_query($con,$sql);
				$data['fankui']="qiandaosuccess";
				echo json_encode($data);
				break;
			case 1:
				$sql="update dutys set etime='$time',over=1 where classid='$classid' and over=0";
				mysqli_query($con,$sql);
				$data['fankui']="qiantuisuccess";
				echo json_encode($data);
				break;
			case 2:
				$data['fankui']="qiantuisuccess";
				echo json_encode($data);
				break;
			case 3:
				$data['fankui']="zaotui";
				echo json_encode($data);
				break;
			
			default:
				$data['fankui']=$i;
				echo json_encode($data);
				break;
		}
	}
}
if (!empty($_GET['classid'])&&!empty($_GET['zaotui']))
{
	$classid=$_GET['classid'];
	$ceshitime=time();
	$date=date("Y-m-d");
	$time=date("H:i:s");
	$week=date("N");
	$aorp=date("a");
	$sql="update dutys set etime='$time',over=1,early=1 where classid='$classid' and over=0";
	mysqli_query($con,$sql);
	header("Location: http://localhost/qiandao_php/index.php");
}
// echo date("Y-m-d")."+++".date("H:i:s")."+++".date("N");