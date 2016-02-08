<?php
if (!empty($_POST['muban'])){
	$list = array("学号&姓名&部门&生日&(正式/试用)&值班时间","13110402096&刘熹&技术部&1994-4-2&正式&1|12,5|34");
	// var_dump($list);
	$fp = fopen('C:\file.csv', 'w');
	foreach ($list as $line) {
		$line=mb_convert_encoding($line,"GBK","utf-8");
		$csvline=explode('&', $line);
		// var_dump($csvline);
		fputcsv($fp,$csvline);
	}
	fclose($fp);
	$data['muban']="success";
	echo json_encode($data);
}
else if(!empty($_GET['tuichu'])&&$_GET['tuichu']=="tuichu")
{
	unset($_SESSION['admin']);
	header("location:../index.php");
}
else
{
	$data['muban']="fail";
	echo json_encode($data);
}