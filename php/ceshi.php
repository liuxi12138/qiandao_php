<?php
// ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');
$classid=13110402096;
$date=date("Y-m-d");
$time=date("H:i:s");
$sum_time=0;
// echo strtotime($date);
// echo "<br />";
// echo strtotime($time);
	$same_sql="select * from dutys where classid='$classid' and date='$date' and over=1;";
	$same_query=mysqli_query($con,$same_sql);
	while($same_array=mysqli_fetch_array($same_query))
	{
		// var_dump($same_array);
		// echo $etime=$same_array['etime'];
				switch($time)
				{
					case $time<='10:00:00':
						$s_ontime="12";
						break;
					case $time>'10:00:00'&&$time<='12:00:00':
						$s_ontime="34";
						break;
					case $time>'12:00:00'&&$time<='16:00:00':
						$s_ontime="56";
						break;
					case $time>'16:00:00'&&$time<='18:00:00':
						$s_ontime="78";
						break;
					case $time>'18:00:00':
						$s_ontime="910";
						break;
				}
				if($s_ontime==$same_array['ontime'])
				{
					$same_ontime=$same_array['ontime'];
					$same_ontime_sql="update dutys set etime='$time' where classid='$classid' and ontime='$same_ontime' and over=1";
					mysqli_query($con,$same_ontime_sql);
				}
	}
	    $sum_time_sql="select * from dutys where `classid`='$classid' and date >= '2017-04-05' and date <= '2017-04-08';";
        $sum_time_query=mysqli_query($con,$sum_time_sql);
        while($sum_time_array=mysqli_fetch_array($sum_time_query))
        {
            $stime=$sum_time_array['stime'];
            $etime=$sum_time_array['etime'];
            $sum_time_add=strtotime($etime)-strtotime($stime);
            $sum_time=$sum_time+$sum_time_add;
            $sum_time_ymd=date('H:i:s',$sum_time);
        }