<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrapDatepickr-1.0.0.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/avalon.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrapDatepickr-1.0.0.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#sdate").bootstrapDatepickr({date_format: "Y-m-d"});
			$("#edate").bootstrapDatepickr({date_format: "Y-m-d"});
		});
	</script>
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
<!-- 网站简介 -->
<div class="modal fade" id="jianjie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">网站简介</h4>
      </div>
      <div class="modal-body">
      	介绍内容
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 使用说明 -->
<div class="modal fade" id="shuoming" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">使用说明</h4>
      </div>
      <div class="modal-body">
      	介绍内容
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 作者简介 -->
<div class="modal fade" id="jiyu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">作者寄语</h4>
      </div>
      <div class="modal-body">
      	介绍内容
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 作者简介 -->
<div class="modal fade" id="zuozhejianjie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">作者简介</h4>
      </div>
      <div class="modal-body">
      	介绍内容
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<!-- 统计值班信息 -->
<div class="modal fade" id="daochu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">统计值班信息</h4>
      </div>
      <div class="modal-body">
		    <div class="form-group">
		      <div class="col-xs-6">
		        <input type="text" id="sdate" placeholder="开始时间" name="sdate" class="form-control">
		      </div>
		      <div class="col-xs-6">
		        <input type="text" id="edate" placeholder="截止时间" name="edate" class="form-control">
		      </div>
		      <button type="submit" class="btn btn-primary qiandao" onclick="javascript:daochu();">导出</button>
		    </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function daochu(){
		var sdate=$("input:text[name='sdate']").val();
		var edate=$("input:text[name='edate']").val();
		if(sdate>edate)
			alert("开始时间要早于截止时间");
		else
		{
		    $.ajax({
		        type: 'POST',
		        url: 'php/export.php',
		        data: {
		                sdate: sdate,
		                edate: edate
		            },
		        dataType: 'json',
		        cache: false,
		        success: function(json){
		        	var daochu=json.daochu;
		            if(daochu=="success")
		            {
	            		alert('导出成功');
	            		window.location.href=window.location.href;
	            	}
	            	else
	            	{
	        			alert("导出程序报错，请联系程序员");
	            		window.location.href=window.location.href;
	            	}
		        }
		    });
		}
	}
</script>

<!-- 导入值班表 -->
<div class="modal fade" id="daoru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">导入值班表</h4>
      </div>
      <div class="modal-body">
			<form class="form-group" method="post" action="php/reader.php" enctype="multipart/form-data">
		        <input type="file" name="file_stu" id="exampleInputFile"/>
		        <input type="submit" class="btn btn-primary qiandao" name="upfile" value="导入" />
			</form>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
	<ul class="nav nav-pills">
		<li role="presentation"><a href="#">后台管理</a></li>
		<li role="presentation"><a href="#" data-toggle="modal" data-target="#jianjie">网站简介</a></li>
		<li role="presentation" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			作者信息 <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
	          <li><a href="#" data-toggle="modal" data-target="#shuoming">使用说明</a></li>
	          <li><a href="#" data-toggle="modal" data-target="#jiyu">作者寄语</a></li>
	          <li role="separator" class="divider"></li>
	          <li><a href="#" data-toggle="modal" data-target="#zuozhejianjie">作者简介</a></li>
	        </ul>
		</li>
	</ul>
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-8 qiandao_table">
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
					<td>
						<?php
							if ($array['class']==0)
								echo "试用 ".$array['name'];
							else if($array['class']==1)
								echo $array['name'];
						?>
					</td>
					<td><?php echo $array['stime'];?></td>
					<td><?php echo $array['etime'];?></td>
					<td><?php echo $array['date'];?></td>
				</tr>
<?php
}
?>
			</table>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">
				<button type="button" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">导出值班表模板</button>
				<button type="button" data-toggle="modal" data-target="#daoru" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">导入值班表</button>
				<button type="button" data-toggle="modal" data-target="#daochu" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">统计值班情况</button>
				<button type="button" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">添加生日</button>
			</div>
		</div>
	</div>
	<div class="row qiandao">
		<div class="form-inline">
			<div class="form-group">
				<div class="input-group">
					<input type="text" class="form-control" autocomplete="off" name="classid" id="exampleInputAmount" placeholder="学号">
				</div>
			</div>
			<div type="submit" class="btn btn-primary" id="qiandao" onclick="javascript:qiandao()">签到</div>
		</div>	
        <script type="text/javascript">
        	$(function(){
				document.getElementById("exampleInputAmount").focus(); 
			});
            // $("div#qiandao").click(function() {
            //     qiandao();
            // });//选择器调用js函数
            function qiandao(){
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
                    // error:function(json){
                    // 	var fankui=json.fankui;
                    // 	if(fankui=="bug"){
                    // 		alert("bug");
                    // 	}
                    // },
                    success: function(json){
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
                        		alert("签到程序报错，请联系程序员");
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