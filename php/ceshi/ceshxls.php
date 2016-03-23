<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>对excel的测试实例_1</title>

</head>
<body>
<?php
 
error_reporting(E_ALL);
 
//设置时区
date_default_timezone_set('Asia/Shanghai');
 
require_once 'Classes/PHPExcel.php';
 
echo '当前时间：'.date('Y:m:d H:i:s');
 
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
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', '我想在这里测试汉字');
 
//对第一个选项进行重命名            
$objPHPExcel->getActiveSheet()->setTitle('重新命令');


$objPHPExcel->setActiveSheetIndex(0);
 
//写操作
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
 
echo "<br/>消耗的内存为：".memory_get_peak_usage(true) / 1024 / 1024;
echo '<div>文件名：'.__FILE__.'</div>';
echo '<div>php编译的行数：'.__LINE__.'</div>';
echo '<div>php的类名：'.__CLASS__.'</div>';
?>
</body>
</html>