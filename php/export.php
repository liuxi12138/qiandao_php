<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>对excel的测试实例_1</title>
</head>
<body>
<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
header("Content-Type: text/html;charset=utf-8");
include('conn.php');
require_once 'Classes/PHPExcel.php';
echo '当前时间：'.date('Y:m:d H:i:s');

$ke_array=array('12'=>"第一，二节",'34'=>"第三，四节",'56'=>"第五，六节",'78'=>"第七，八节",'910'=>"第九，十节");

//接收统计的起止日期
$sdate="2016-1-1";
$edate="2016-2-3";


//计算这一周一共几个星期
$sum_days=(strtotime($edate)-strtotime($sdate))/86400+1;
$sweek=date("N",strtotime($sdate));
$eweek=date("N",strtotime($edate));
// echo $sum_days."+++".$sweek."+++".$eweek."<br />";
$sum_weeks=floor($sum_days/7);



//创建excel操作对象
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("青春在线")
                             ->setLastModifiedBy("Meteoric002")
                             ->setTitle("值班签到统计")
                             ->setSubject("主题1")
                             ->setDescription("随便一个描述了")
                             ->setKeywords("关键字 用空格分开")
                             ->setCategory("分类 ");

//激活第一个选项， 然后填充数据
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '姓名')
            ->setCellValue('B1', '值班总次数')
            ->setCellValue('C1', '未签退')
            ->setCellValue('D1', '按要求在岗')
            ->setCellValue('E1', '早退次数')
            ->setCellValue('F1', '额外值班次数')
            ->setCellValue('G1', '缺勤次数')
            ->setCellValue('H1', '缺勤时间');

    $x=2;
    $user_query=mysqli_query($con,"select * from users;");
while($user_array=mysqli_fetch_array($user_query))
{
        $classid=$user_array['classid'];
        $sql="select *,count(*) from dutys where `classid`='$classid' and date >= '$sdate' and date <= '$edate';";
        $query=mysqli_query($con,$sql);
        $array=mysqli_fetch_array($query);
        $over_sql="select count(*) from dutys where `classid`='$classid' and date >= '$sdate' and date <= '$edate' and over=0;";
        $over_query=mysqli_query($con,$over_sql);
        $over_array=mysqli_fetch_array($over_query);
        // 是否缺勤算法
            //数组初始化
            $anshi_zhiban=0;
            $no_anshi_zhiban=0;
            $anpai_zhiban=0;
            $anshi_zhiban_array[$classid][]=0;
            $no_anshi_zhiban_array[$classid][]=0;
        $user_dutys_sql="select * from user_dutys where classid='$classid';";
        $user_dutys_query=mysqli_query($con,$user_dutys_sql);
        while($user_dutys_array=mysqli_fetch_array($user_dutys_query))
        {
            if ($user_dutys_array["onweek"]>=$sweek)
            {
                $first_week_cha=$user_dutys_array["onweek"]-$sweek;//排版星期与统计第一天在同一个星期里
            }
            else
            {
                $first_week_cha=(7-$sweek)+$user_dutys_array["onweek"]."<br />";//排版星期在。统计第一天的下一个星期里
            }
            for ($i=0;$i<=$sum_weeks;$i++)
            {
                $zaigang_unix=strtotime($sdate)+$first_week_cha*86400+86400*7*$i;
                $zhiban=date("Y-m-d",$zaigang_unix);
                if(strtotime($zhiban)>strtotime($edate))//超过统计的截止时间，跳出。
                    {break;}
                // echo $zhiban."<br />";
                $zhiban_sql="select * from dutys where classid='$classid' and date='$zhiban' and ontime='$user_dutys_array[ontime]'";
                $zhiban_query=mysqli_query($con,$zhiban_sql);
                $zhiban_array=mysqli_fetch_array($zhiban_query);
                if(!empty($zhiban_array))
                {
                    // var_dump($zhiban_array);
                    $anshi_zhiban_array[$classid][$anshi_zhiban]="\"".date("Y-m-d l",strtotime($zhiban_array['date']))." ".$ke_array[$zhiban_array['ontime']]."\"";
                    $anshi_zhiban++;
                }
                else
                {
                    $no_anshi_zhiban_array[$classid][$no_anshi_zhiban]="\"".date("Y-m-d l",strtotime($zhiban))." ".$ke_array[$user_dutys_array['ontime']]."\"";
                    $no_anshi_zhiban++;
                }
                $anpai_zhiban++;
            }
        }
        //是否缺勤算法end

        $early_sql="select count(*) from dutys where classid='$classid' and early=1 and over=1";
        $early_query=mysqli_query($con,$early_sql);
        $early=mysqli_fetch_array($early_query);
        $queqin_xiangxi="";
        foreach ($no_anshi_zhiban_array[$classid] as $k=>$v)
        {
            $queqin_xiangxi= $queqin_xiangxi.$v."&CHAR(10)&";
        }
        $queqin_xiangxi="=".$queqin_xiangxi."\" \"";
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$x", $user_array['name'])
            ->setCellValue("B$x", $array['count(*)'])
            ->setCellValue("C$x", $over_array['count(*)'])
            ->setCellValue("D$x", $anshi_zhiban)
            ->setCellValue("E$x", $early["count(*)"])
            ->setCellValue("F$x", $ewai_zhiban=$array['count(*)']-$anpai_zhiban)
            ->setCellValue("G$x", $no_anshi_zhiban)
            ->setCellValue("H$x", $queqin_xiangxi);
    $objPHPExcel->getActiveSheet()->getStyle("A1:H$x")->getAlignment()->setWrapText(true);//自动换行
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
    // //设置列宽
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('30');

    // // 设置行高
    // $objPHPExcel->getActiveSheet()->getRowDimension("2")->setRowHeight("150");
    $x++;
}
//设置单元格边框
// $styleThinBlackBorderOutline = array(
//     'borders' => array (
//        'outline' => array (
//           'style' => PHPExcel_Style_Border::BORDER_THIN,  //设置border样式
//           // 'style' => PHPExcel_Style_Border::BORDER_THICK, //另一种样式
//           'color' => array ('argb' => 'FF000000'),     //设置border颜色
//       ),
//    ),
// );
// $objPHPExcel->getActiveSheet()->getStyle( "A1:H$x")->applyFromArray($styleThinBlackBorderOutline);
//对第一个选项进行重命名
$objPHPExcel->getActiveSheet()->setTitle('值班统计');


$objPHPExcel->setActiveSheetIndex(0);
 
//写操作
$filename=$sdate."-".$edate.".xlsx";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filename);
$oldname=dirname(__FILE__)."\\".$filename;
$newname="c:\\".$filename;
// rename("$oldname", "$newname");//移动文件
copy("$oldname", "$newname");//复制文件
 
echo "<br/>消耗的内存为：".memory_get_peak_usage(true) / 1024 / 1024;
echo '<div>文件名：'.__FILE__.'</div>';
echo '<div>php编译的行数：'.__LINE__.'</div>';
echo '<div>php的类名：'.__CLASS__.'</div>';
?>
</body>
</html>