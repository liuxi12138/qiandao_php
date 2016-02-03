<?php
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
$time=date("H:i:s");
switch($time)
{
	case $time<='10:00:00':
		$ontime="12";
		echo $ontime;
		break;
	case $time>'10:00:00'&&$time<='12:00:00':
		$ontime="34";
		echo $ontime;
		break;
	case $time>'12:00:00'&&$time<='16:00:00':
		$ontime="56";
		echo $ontime;
		break;
	case $time>'16:00:00'&&$time<='18:00:00':
		$ontime="78";
		echo $ontime;
		break;
	case $time>'18:00:00':
		$ontime="910";
		echo $ontime;
		break;
}



	// if ($time<='10:00:00')
	// 	echo "十点之前";
	// if ($time>'10:00:00'&&$time<='12:00:00')
	// 	echo "十点至十二点";
	// if ($time>'12:00:00'&&$time<='16:00:00')
	// 	echo "十二点至十六点";
	// if ($time>'16:00:00'&&$time<='18:00:00')
	// 	echo "十六点至十八点";
	// if ($time>'18:00:00')
	// 	echo "十八点之后";