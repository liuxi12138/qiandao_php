<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');

//接收统计的起止日期
$sdate="2016-1-1";
$edate="2016-2-3";


$sum_days=(strtotime($edate)-strtotime($sdate))/86400+1;
$sweek=date("N",strtotime($sdate));
$eweek=date("N",strtotime($edate));
echo $sum_days."+++".$sweek."+++".$eweek."<br />";

//计算这一周一共几个星期
$sum=0;
echo $sum_weeks=floor($sum_days/7);
for ($i=1;$i<=$sum_weeks;$i++)
{
	$zhiban;
}

//计算按时值班的次数and一共值了几次班
$classid="13110402096";
$user_dutys_sql="select * from user_dutys where classid='$classid';";
$user_dutys_query=mysqli_query($con,$user_dutys_sql);

$anshi_zhiban=0;
$anpai_zhiban=0;
while($user_dutys_array=mysqli_fetch_array($user_dutys_query))
{
	if ($user_dutys_array["onweek"]>=$sweek)
	{
		echo "<br />及其之后";
		echo $first_week_cha=$user_dutys_array["onweek"]-$sweek;
	}
	else
	{
		echo "<br />之前";
		echo $first_week_cha=(7-$sweek)+$user_dutys_array["onweek"]."<br />";
	}
	for ($i=0;$i<=$sum_weeks;$i++)
	{
		$zhiban=date("Y-m-d",strtotime($sdate)+$first_week_cha*86400+86400*7*$i);
		if(strtotime($zhiban)>strtotime($edate))
			{break;}
		echo $zhiban."<br />";
		$zhiban_sql="select * from dutys where classid='$classid' and date='$zhiban' and ontime='$user_dutys_array[ontime]'";
		$zhiban_query=mysqli_query($con,$zhiban_sql);
		$zhiban_array=mysqli_fetch_array($zhiban_query);
		if(!empty($zhiban_array))
		{
			$anshi_zhiban++;
			var_dump($zhiban_array);
		}
		$anpai_zhiban++;
	}
}
echo "<br />按时值班次数".$anshi_zhiban;
echo "<br />安排值班总次数".$anpai_zhiban;

//计算安排值班的次数end

// var_dump($array);
	echo "<table border=2>";
	echo "<tr>";
	echo "<td>姓名</td>";
	echo "<td>值班总次数</td>";
	echo "<td>未签退</td>";
	echo "<td>按要求在岗</td>";
	echo "<td>早退次数</td>";
	echo "<td>额外值班次数</td>";
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
		$zaigang_sql="select count(*) from user_dutys,dutys where `user_dutys`.`classid`='$classid' and `user_dutys`.`onweek`=`dutys`.`week` and `user_dutys`.`ontime`=`dutys`.`ontime` and `dutys`.`over`='1' and date >= '$sdate' and date <= '$edate';";
		$zaigang_query=mysqli_query($con,$zaigang_sql);
		$zaigang=mysqli_fetch_array($zaigang_query);
		// var_dump($zaigang);
	echo "<td>".$zaigang["count(*)"]."</td>";//按要求在岗
		$early_sql="select count(*) from dutys where classid='$classid' and early=1 and over=1";
		$early_query=mysqli_query($con,$early_sql);
		$early=mysqli_fetch_array($early_query);
	echo "<td>".$early["count(*)"]."</td>";//早退次数
	echo "<td>".$user_array['name']."</td>";//额外值班次数

	echo "<td>".$user_array['name']."</td>";//缺勤时间
	echo "</tr>";
	
}
	echo "</table>";

	
