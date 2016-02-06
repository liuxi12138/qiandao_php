<?php
error_reporting(E_ERROR);
ini_set('date.timezone','Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include("conn.php");
if(!empty($_POST['birthday']))
{
	$classid=$_POST['classid'];
	$birthday=$_POST['birthday'];
	$select_user_sql="select * from users where classid='$classid'";
    $select_user_qurey=mysqli_query($con,$select_user_sql);
    $select_user_array=mysqli_fetch_array($select_user_qurey);
    if (!empty($select_user_array))
    {
    	$update_birthday="update users set birthday='$birthday' where classid='$classid';";
    	mysqli_query($con,$update_birthday);
    	$data['shengri']="success";
    	echo json_encode($data);
    }
    else
    {
    	$data['shengri']="nouser";
    	echo json_encode($data);
    }
}
else
{
    echo "请用正确的方式访问";
}