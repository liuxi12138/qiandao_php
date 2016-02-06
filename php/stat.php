<!DOCTYPE html>
<html>
<head>
	<title>值班统计</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script type="text/javascript" src="../js/avalon.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
</head>
<body>
<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
// header("Content-Type:application/vnd.ms-excel");  
// header("Content-Disposition:attachment;filename=sample.xls");  
// header("Pragma:no-cache");  
// header("Expires:0");
include('conn.php');

$ke_array=array('12'=>"第一，二节",'34'=>"第三，四节",'56'=>"第五，六节",'78'=>"第七，八节",'910'=>"第九，十节");

//接收统计的起止日期
$sdate="2016-1-1";
$edate="2016-2-3";


//计算这一周一共几个星期
$sum_days=(strtotime($edate)-strtotime($sdate))/86400+1;
$sweek=date("N",strtotime($sdate));
$eweek=date("N",strtotime($edate));
// echo $sum_days."+++".$sweek."+++".$eweek."<br />";
$sum_weeks=floor($sum_days/7);


// var_dump($array);
	echo "<table class=\"table table-striped\">";
	echo "<tr>";
	echo "<td>姓名</td>";
	echo "<td>值班总次数</td>";
	echo "<td>未签退</td>";
	echo "<td>按要求在岗</td>";
	echo "<td>早退次数</td>";
	echo "<td>额外值班次数</td>";
	echo "<td>缺勤次数</td>";
	echo "<td>缺勤时间</td>";
	echo "</tr>";
	$user_query=mysqli_query($con,"select * from users;");
while($user_array=mysqli_fetch_array($user_query))
{
		$classid=$user_array['classid'];
		$sql="select *,count(*) from dutys where `classid`='$classid' and date >= '$sdate' and date <= '$edate';";
		$query=mysqli_query($con,$sql);
		$array=mysqli_fetch_array($query);
		// var_dump($array);
	echo "<tr>";
	echo "<td>".$user_array['name']."</td>";//姓名
	echo "<td>".$array['count(*)']."</td>";//签到总次数
		$over_sql="select count(*) from dutys where `classid`='$classid' and date >= '$sdate' and date <= '$edate' and over=0;";
		$over_query=mysqli_query($con,$over_sql);
		$over_array=mysqli_fetch_array($over_query);
	echo "<td>".$over_array['count(*)']."</td>";//未签退
		// $zaigang_sql="select count(*) from user_dutys,dutys where `user_dutys`.`classid`='$classid' and `user_dutys`.`onweek`=`dutys`.`week` and `user_dutys`.`ontime`=`dutys`.`ontime` and `dutys`.`over`='1' and date >= '$sdate' and date <= '$edate';";
		// $zaigang_query=mysqli_query($con,$zaigang_sql);
		// $zaigang=mysqli_fetch_array($zaigang_query);
		// var_dump($zaigang);

		// 是否缺勤算法
			//数组初始化
			$anshi_zhiban=0;
			$no_anshi_zhiban=0;
			$anpai_zhiban=0;
			$anshi_zhiban_array[$classid][]=0;
			$no_anshi_zhiban_array[$classid][]=0;
		$user_dutys_sql="select * from user_dutys where classid='$classid';";
		$user_dutys_query=mysqli_query($con,$user_dutys_sql);
		while($user_dutys_array=mysqli_fetch_array($user_dutys_query))
		{
			if ($user_dutys_array["onweek"]>=$sweek)
			{
				$first_week_cha=$user_dutys_array["onweek"]-$sweek;//排版星期与统计第一天在同一个星期里
			}
			else
			{
				$first_week_cha=(7-$sweek)+$user_dutys_array["onweek"]."<br />";//排版星期在。统计第一天的下一个星期里
			}
			for ($i=0;$i<=$sum_weeks;$i++)
			{
				$zaigang_unix=strtotime($sdate)+$first_week_cha*86400+86400*7*$i;
				$zhiban=date("Y-m-d",$zaigang_unix);
				if(strtotime($zhiban)>strtotime($edate))//超过统计的截止时间，跳出。
					{break;}
				// echo $zhiban."<br />";
				$zhiban_sql="select * from dutys where classid='$classid' and date='$zhiban' and ontime='$user_dutys_array[ontime]'";
				$zhiban_query=mysqli_query($con,$zhiban_sql);
				$zhiban_array=mysqli_fetch_array($zhiban_query);
				if(!empty($zhiban_array))
				{
					// var_dump($zhiban_array);
					$anshi_zhiban_array[$classid][$anshi_zhiban]=date("Y-m-d l",strtotime($zhiban_array['date']))." ".$ke_array[$zhiban_array['ontime']]."; ";
					// $anshi_zhiban_array[$classid][$anshi_zhiban]=date("Y-m-d l",strtotime($zhiban_array['date']))." ".$ke_array[$zhiban_array['ontime']]."<br />";
					$anshi_zhiban++;
				}
				else
				{
					$no_anshi_zhiban_array[$classid][$no_anshi_zhiban]=date("Y-m-d l",strtotime($zhiban))." ".$ke_array[$user_dutys_array['ontime']]."; ";
					// $no_anshi_zhiban_array[$classid][$no_anshi_zhiban]=date("Y-m-d l",strtotime($zhiban))." ".$ke_array[$user_dutys_array['ontime']]."<br />";
					$no_anshi_zhiban++;
				}
				$anpai_zhiban++;
			}
		}
		//是否缺勤算法end
	echo "<td>".$anshi_zhiban."</td>";//按要求在岗

		$early_sql="select count(*) from dutys where classid='$classid' and early=1 and over=1";
		$early_query=mysqli_query($con,$early_sql);
		$early=mysqli_fetch_array($early_query);
	echo "<td>".$early["count(*)"]."</td>";//早退次数

	echo "<td>".$ewai_zhiban=$array['count(*)']-$anpai_zhiban."</td>";//额外值班次数
	echo "<td>".$no_anshi_zhiban."</td>";

	echo "<td>";//缺勤时间
		// foreach ($no_anshi_zhiban_array[$classid] as $k=>$v)
		// {
		//     echo $v." ";
		// }
		$queqin_xiangxi="";
		foreach ($no_anshi_zhiban_array[$classid] as $k=>$v)
		{
		    $queqin_xiangxi= $queqin_xiangxi."\"".$v."\"&CHAR(10)&";
		}
		echo "=".$queqin_xiangxi."\" \"";

	echo "</td>";
	echo "</tr>";
}
	echo "</table>";
?>
</body>
</html>