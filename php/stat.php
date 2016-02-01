<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');

//接收统计的起止日期
$sdate="2016-1-1";
$edate="2016-1-31";
//查询dutys表中


// $sql="select * from users,dutys where `users`.`classid`=`dutys`.`classid` and date >= '$sdate' and date <= '$edate';";
// $query=mysqli_query($con,$sql);
// $array=mysqli_fetch_array($query);


// var_dump($array);
	echo "<table>";
	echo "<tr>";
	echo "<td>姓名</td>";
	echo "<td>值班总次数</td>";
	echo "<td>按要求在岗</td>";
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
	echo "<td>".$user_array['name']."</td>";
	// $classid=$array['classid'];
	// $num_sql="select count(*) from dutys where `dutys`.`classid`='$classid' and date >= '$sdate' and date <= '$edate';";
	// $num_query=mysqli_query($con,$num_sql) or die("1");
	// $num_array=mysqli_fetch_array($num_query);
	echo "<td>".$array['count(*)']."</td>";
	$zaigang_sql="select count(*) from users,dutys where `users`.`classid`=`dutys`.`classid` and `users`.`onweek`=`dutys`.`week` and `users`.`ontime`=`dutys`.`ontime`;";
	$zaigang_query=mysqli_query($con,$sql) or die("2");
	$zaigang=mysqli_fetch_array($zaigang_query);
	echo "<td>".$zaigang[0]."</td>";
	echo "<td>".$user_array['name']."</td>";
	echo "<td>".$user_array['name']."</td>";
	echo "</tr>";
	
}
	echo "</table>";

	
