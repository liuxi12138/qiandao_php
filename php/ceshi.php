<?php
ini_set('date.timezone','Asia/Shanghai');
include("conn.php");
$time=date("H:i:s");
$early_sql="select * from dutys where over=0;";
$early_query=mysqli_query($con,$early_sql);
$early_array=mysqli_fetch_array($early_query);
$stime=$early_array['stime'];
$time_cha=strtotime($time)-strtotime($stime);
if($time_cha<=4200)


// echo $time."+++".$stime."+++".date("Y-m-d H:i:s",$time_cha)."+++".$time_cha;
