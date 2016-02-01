<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');

//接收统计的起止日期
$sdate="2016-1-1";
$edate="2016-1-31";
//查询dutys表中
$sql="select * from dutys where date > '$sdate' and date < '$edate';";
$query=mysqli_query($con,$sql);

while($array=mysqli_fetch_array($query))
{
	var_dump($array);
}
