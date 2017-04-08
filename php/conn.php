<?php
header("Content-Type: text/html;charset=utf-8");
$con=mysqli_connect("localhost","root","youth123","qiandao")or die("数据库链接失败");
//字符转换，读库
mysqli_query($con,"set character set utf8");
//写库
mysqli_query($con,"set names utf8");

function selete_array($sql)
{
	$query=mysqli_query($con,$sql);
	$array=mysqli_fetch_array($query);
	return $array;
}
function no_selete($sql)
{
	mysqli_query($con,$sql);
}