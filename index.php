<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/avalon.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<?php
include("php/conn.php");
ini_set('date.timezone','Asia/Shanghai');
$date=date("Y-m-d");
$sql="select * from `dutys`,`users` where date='$date' and `dutys`.`classid`=`users`.`classid` order by etime desc;";
$query=mysqli_query($con,$sql);
// var_dump(mysqli_fetch_array($query));
?>
<body>
<div class="container-fluid">
	<ul class="nav nav-pills">
		<li role="presentation"><a href="#">后台管理</a></li>
		<li role="presentation"><a href="#">网站简介</a></li>
		<li role="presentation" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			作者信息 <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
	          <li><a href="#">使用说明</a></li>
	          <li><a href="#">作者寄语</a></li>
	          <li role="separator" class="divider"></li>
	          <li><a href="#">作者简介</a></li>
	        </ul>
		</li>
	</ul>
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-8">
			<table class="table table-striped">
				<tr>
					<td>姓名</td>
					<td>签到时间</td>
					<td>签退时间</td>
					<td>值班日期</td>
				</tr>
<?php
while($array=mysqli_fetch_array($query))
{
?>
				<tr>
					<td><?php echo $array['name'];?></td>
					<td><?php echo $array['stime'];?></td>
					<td><?php echo $array['etime'];?></td>
					<td><?php echo $array['date'];?></td>
				</tr>
<?php
}
?>
			</table>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4">附加功能框</div>
	</div>
	<div class="row qiandao">
		<div class="form-inline">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" autocomplete="off" name="classid" id="exampleInputAmount" placeholder="学号">
				</div>
			</div>
			<div type="submit" class="btn btn-primary" id="qiandao">签到</div>
		</div>	
        <script type="text/javascript">
        	$(function(){
				document.getElementById("exampleInputAmount").focus(); 
			})
			// $(function(){
			// 	$("#exampleInputAmount").focus();
			// })
            $("div#qiandao").click(function() {
                qiandao();
            });
            function qiandao() {
        		var classid=$("input:text[name='classid']").val();
            	// alert(classid);
                $.ajax({
                    type: 'POST',
                    url: 'php/qiandao.php',
                    data: {
                            classid: classid
                        },
                    dataType: 'json',
                    cache: false,
                    success: function(json) {
                    	var fankui=json.fankui;
                        switch(fankui)
                        {
                        	case "nouser":
                        		alert('学号不存在');
                        		window.location.href=window.location.href;
                        		break;
                        	case "qiandaosuccess":
                        		alert('签到成功');
                        		window.location.href=window.location.href;
                        		break;
                        	case "qiantuisuccess":
                        		alert('签退成功');
                        		window.location.href=window.location.href;
                        		break;
                        	case "zaotui":
                        		if(confirm("现在签退为时过早，是否继续签退？"))
							    {
							        window.location.href="http://localhost/qiandao_php/php/qiandao.php?zaotui=jixu&classid="+classid;
							    }
							    else
							    {
							      alert("恭喜，请继续享受在网站的时光吧！");
							      window.location.href=window.location.href;
							    }
                        		// alert('早退');
                        		// window.location.href=window.location.href;
                        		break;
                        	default:
                        		alert('程序报错，请联系程序员');
                        		window.location.href=window.location.href;
                        		break;
                        }
                    }
                });
            }
        </script>
	</div>
</div>
</div>
</body>
</html>