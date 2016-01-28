<?php
header("Content-Type: text/html;charset=utf-8");
$con=mysqli_connect("localhost","root","","qiaodao")or die("数据库链接失败");
//字符转换，读库
mysqli_query($con,"set character set utf8");
//写库
mysqli_query($con,"set names utf8");