<?php
session_start();
include("php/conn.php");
include_once("php/nongli.php");
$rili=array('公历','农历');
ini_set('date.timezone','Asia/Shanghai');
$date=date("Y-m-d");
$sql="select * from `dutys`,`users` where date='$date' and `dutys`.`classid`=`users`.`classid` order by etime desc;";
$query=mysqli_query($con,$sql);
// var_dump(mysqli_fetch_array($query));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrapDatepickr-1.0.0.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- // <script type="text/javascript" src="js/avalon.js"></script> -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrapDatepickr-1.0.0.js"></script>
	<script>
		$(document).ready(function() {
			$("#sdate").bootstrapDatepickr({date_format: "Y-m-d"});
			$("#edate").bootstrapDatepickr({date_format: "Y-m-d"});
			$("#birthday").bootstrapDatepickr({date_format: "Y-m-d"});
		});
	</script>
	<?php
		//验证密码定义session
		if (!empty($_POST['pwd'])&&$_POST['pwd']=="nikendingbuzhidao!")
		{
			$_SESSION['admin']="right";
		}
		else if(!empty($_GET['tuichu'])&&$_GET['tuichu']=="tuichu")
		{
			unset($_SESSION['admin']);
			header("location:index.php");
		}
	?>
</head>

<body onkeydown="BindEnter(event)">
<!-- 登录 -->
<div class="modal fade" id="back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">登录</h4>
      </div>
      <div class="modal-body">
      	<form class="form-group row" action="index.php" method="post">
		      <div class="col-xs-10 col-xs-offset-1">
		        <input type="password" name="pwd" class="form-control">
		      </div>
		      <div class="col-xs-10 col-xs-offset-1">
		      	<button type="submit" class="btn btn-primary col-xs-12">登录</button>
		      </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

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
		      <div class="col-xs-6 col-md-6 col-xs-6">
		        <input type="text" id="sdate" placeholder="开始时间" name="sdate" class="form-control">
		      </div>
		      <div class="col-xs-6 col-md-6 col-xs-6">
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
	            		alert('导出值班统计成功');
	            		window.location.href=window.location.href;
	            	}
	            	else
	            	{
	        			alert("导出值班统计程序报错，请联系程序员");
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

<!-- 导出添加生日 -->
<div class="modal fade" id="birthday_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">添加生日</h4>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label>学号</label>
			<input type="text" name="birth_classid" class="form-control">
		</div>
		<div class="form-group">
			<label for="birthday">生日</label>
			<div class="row">
			  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			    <input type="text" name="birthday" id="birthday" autocomplete="off" placeholder="1994-04-02" class="form-control">
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			      <select name="isnongli" class="form-control">
			          <option value="0">过公历生日</option>
			          <option value="1">过农历生日</option>
			      </select>
			  </div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary qiandao" onclick="javascript:birthday();">添加</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
		<script type="text/javascript">
		function birthday(){
			var birth_classid=$("input:text[name='birth_classid']").val();
			var birthday=$("input:text[name='birthday']").val();
			var isnongli=$("select[name='isnongli']").val();
		    $.ajax({
		        type: 'POST',
		        url: 'php/addbirthday.php',
		        data: {
		        		classid: birth_classid,
		                birthday: birthday,
		                isnongli: isnongli
		            },
		        dataType: 'json',
		        cache: false,
		        error:function(json){
		        	alert("ajax失败");
		        },
		        success: function(json){
		        	var shengri=json.shengri;
		            if(shengri=="success")
		            {
	            		alert('添加生日成功');
	            		window.location.href=window.location.href;
	            	}
	            	else if(shengri=="nouser")
	            	{
	            		alert('添加生日失败，未找到该用户');
	            		window.location.href=window.location.href;
	            	}
	            	else
	            	{
	        			alert("添加生日程序报错，请联系程序员");
	            		window.location.href=window.location.href;
	            	}
		        }
		    });
		}
		</script>

<!-- 主界面 -->
<div class="container-fluid">
	<ul class="nav nav-pills">
		<li role="presentation"><a href="#" data-toggle="modal" data-target="#back">后台管理</a></li>
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
							switch ($array['class']) {
								case 0:
									echo "试用 ".$array['name'];
									break;
								case 2:
									echo $array['name']." 回家了";
									break;
								default:
									echo $array['name'];
									break;
							}
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
			<div class="col-md-12 col-sm-12 col-xs-12">
			<?php
			//判断登录是否成功
			if (!empty($_SESSION['admin'])&&$_SESSION['admin']=="right") {
			?>
				<a href="php/user_table.php">
					<button type="button" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" >用户管理</button>
				</a>
				<button type="button" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" onclick="javascript:muban();">导出值班表模板</button>
				<button type="button" data-toggle="modal" data-target="#daoru" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">导入值班表</button>
				<button type="button" data-toggle="modal" data-target="#daochu" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">统计值班情况</button>
				<button type="button" data-toggle="modal" data-target="#birthday_add" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">添加生日</button>
				<a href="index.php?tuichu=tuichu"><!--借这个文件用一下，清除一下登录记录，懒得单独写个文件了-->
					<button class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">退出登录</button>
				</a>
			<?php
			}else{
			?>
				<button type="button" disabled="disabled" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" >用户管理</button>
				<button type="button" disabled="disabled" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2" onclick="javascript:muban();">导出值班表模板</button>
				<button type="button" disabled="disabled" data-toggle="modal" data-target="#daoru" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">导入值班表</button>
				<button type="button" disabled="disabled" data-toggle="modal" data-target="#daochu" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">统计值班情况</button>
				<button type="button" data-toggle="modal" data-target="#birthday_add" class="btn btn-primary col-md-8 col-sm-8 col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2">添加生日</button>
			<?php
			}
			?>
			</div>
		</div>
		<script type="text/javascript">
		function muban(){
			var muban="not_null";
		    $.ajax({
		        type: 'POST',
		        url: 'php/makecsv.php',
		        data: {
		                muban: muban
		            },
		        dataType: 'json',
		        cache: false,
		        success: function(json){
		        	var daochu_muban=json.muban;
		            if(daochu_muban=="success")
		            {
	            		alert('导出模板成功，C:\\file.csv');
	            		window.location.href=window.location.href;
	            	}
	            	else
	            	{
	        			alert("导出模板程序报错，请联系程序员");
	            		window.location.href=window.location.href;
	            	}
		        }
		    });
		}
		</script>
	</div>
	<!-- 循环展示提示语 -->
	<div class="row qiandao">
		<div id="scrollDiv">
			<ul>
				<?php
					$show_birthday="select * from users";
					$show_birthday_query=mysqli_query($con,$show_birthday);
					while($show_birthday_array=mysqli_fetch_array($show_birthday_query))
					{
						$date=date("Y-m-d");
						if ($show_birthday_array['isnongli']==1)
						{
							$lunar = new Lunar();
							$date = date("Y-m-d",$lunar->S2L($date));
						}
						if (date("m-d",strtotime($date))==date("m-d",strtotime($show_birthday_array['birthday'])))
						echo "<li>今天是".$show_birthday_array['name']."的".$rili[$show_birthday_array['isnongli']]."生日</li>";
					}
				?>
				<li>青春在线，精彩无限。</li>
				<li>网站是我们的孩子，我们是网站的孩子。</li>

				<li>有什么问题记得向学长学姐请教，千万不要害羞哦。</li>
				<li>美好大学时光，感谢有你相伴。</li>
				<li>早晨值班记得给网站打扫卫生哦。</li>
			    <!-- <li>当你的翅膀没了力量，激情衰退，实在是飞不动的时候，就飞了一半了。</li> -->
			    <li>一定要珍惜在网站的每一天哦。</li>
				<li>想加自定义的话可以联系程序猿/媛。</li>
			    <!-- <li>每天叫你起床的不是闹钟，是梦想。</li> -->

			</ul>
		</div>
		<style type="text/css">
		ul,li{margin:0;padding:0}
			#scrollDiv{width:600px;height:25px;line-height:25px;overflow:hidden}
			#scrollDiv li{height:25px;padding-left:10px;}
		</style>
		<script type="text/javascript">
			function AutoScroll(obj){
				$(obj).find("ul:first").animate({
			 		marginTop:"-25px"
				},1500,function(){
					$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
				});
			}
			$(document).ready(function(){
				setInterval('AutoScroll("#scrollDiv")',3000);
			});
		</script>
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
			function BindEnter(obj) {//监控回车按键，完成签到操作
				var button = document.getElementById('qiandao');    
				if(obj.keyCode == 13)
				{
					button.click();
					obj.returnValue = false; 
				}
			}
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
                    error:function(json){
                    	alert('ajax失败');
                    },
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
							        window.location.href="php/qiandao.php?zaotui=jixu&classid="+classid;
							    }
							    else
							    {
							      alert("请继续享受在网站的时光吧！");
							      window.location.href=window.location.href;
							    }
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