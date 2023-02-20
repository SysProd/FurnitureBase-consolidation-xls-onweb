<?session_start();?>
<?php
 error_reporting(0);
set_time_limit(0);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Moscow');
if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');
/**
 * Check if current request is AJAX.
 */
 function badscript_is_ajax() {
   return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
     && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
 }
  if(badscript_is_ajax() && crypt('asdkre2334kkhn667bv5' ,$_POST['sid'])==$_POST['sid']){
// if(isset($_POST['name']) && isset($_POST['ed_izmr']) && isset($_POST['kol_vo']) && isset($_POST['name1']) && isset($_POST['ed_izmr1']) && isset($_POST['kol_vo1'])){

$matches_array 		= $_SESSION['matches_array'];
$differences_array 	= $_SESSION['differences_array'];

$names 			= json_decode($_POST['name'], TRUE);
$ed_izmrs		= json_decode($_POST['ed_izmr'], TRUE);
$kol_vos 		= json_decode($_POST['kol_vo'], TRUE);
$pti 			= json_decode($_POST['pti'], TRUE);

$names1 		= json_decode($_POST['name1'], TRUE);
$ed_izmrs1 		= json_decode($_POST['ed_izmr1'], TRUE);
$kol_vos1 		= json_decode($_POST['kol_vo1'], TRUE);
$pti1 			= json_decode($_POST['pti1'], TRUE);

$name = explode("\t", $names);
$ed_izmr = explode("\t", $ed_izmrs);
$kol_vo = explode("\t", $kol_vos);
$puti = explode("\t", $pti);

$name1 = explode("\t", $names1);
$ed_izmr1 = explode("\t", $ed_izmrs1);
$kol_vo1 = explode("\t", $kol_vos1);
$puti1 = explode("\t", $pti1);

require_once dirname(__FILE__) . '/PHP/PHPExcel.php'; // подключаем фреймворк
// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Параметры документа
$xls->getProperties()->setCreator("Игорь Игоревич")
							 ->setLastModifiedBy("Игорь Игоревич")
							 ->setTitle("Автоматически создан документ от php скрипта консолидации")
							 ->setSubject("Автоматически создан документ от php скрипта консолидации")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Таблица обработанных материалов');
$sheet->setCellValue("B1", 'Наименование');
$sheet->setCellValue("C1", 'Ед. Измр.');
$sheet->setCellValue("D1", 'Кол-во');
$sheet->setCellValue("E1", 'Пути');
//$sheet->setCellValueByColumnAndRow(1,$id,$val);
$r=2;
$s=2;
$m=2;
$p=2;

// Объеденить массивы
	$result = array_merge($matches_array, $differences_array);

// Сортировка многомерного массива
    usort($result, function($a, $b){
        if($a['name'] === $b['name'])
            return 0;
        return $a['name'] > $b['name'] ? 1 : -1;
    });
	
	foreach($result as $val){
		$sheet->setCellValueByColumnAndRow(1,$r++,$val['name']);
        $sheet->setCellValueByColumnAndRow(2,$s++,$val['ed_izmr']);
        $sheet->setCellValueByColumnAndRow(3,$m++,$val['kol_vo']);
        $sheet->setCellValueByColumnAndRow(4,$p++,$val['puti']);
		}

$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);

// Путь к файлу .xls
$file_path = '/obrob/xsd.xls';
$patch = dirname(__FILE__) .$child_path.$file_path;
// Удаление файла в директории
 if ( file_exists($patch)) { if ( !(@unlink($patch)) ){ echo 'Error Delete file xls'; } }
// Выводим содержимое файла
	// Тут мы просто записываем файл
  $objWriter = new PHPExcel_Writer_Excel5($xls);
  $objWriter->save('obrob/xsd.xls');
   // Очистка данных PHPExcel библиотеки
  $xls->disconnectWorksheets(); unset($xls);
   // Вывод ссылки на скачивание файла xls
  echo '<a href="http://'.$_SERVER["SERVER_NAME"].'/consolidation'.$file_path.'" id="file">Обработанный EXEL файл</a>';
   // cleaning session variables  
 unset($_SESSION['matches_array']);
 unset($_SESSION['differences_array']);
 exit;
  }


/*блок загрузки файлов*/					if($_FILES['uploadfile']['name'])
{
  header("Content-type: text/html; charset='utf-8'");

											$structure = './uploadfile/';
											//mkdir($structure); //создание папки
											$file = $structure . $_FILES['uploadfile']['name'];
											$maxFileSize = 15 * 1024 * 1024;		/*  ограничить размер загрузки  до 15 MB*/
											$allowedExt = array('xls','xlsx');		/* Формат загрузки файлов*/
											$size = $_FILES['uploadfile']['size'];  /* размер файла */
/*проверка формат файлов*/						$ext = end(explode('.', strtolower($_FILES['uploadfile']['name']))); if(!in_array($ext, $allowedExt)) {echo "Данный формат запрещен";exit;}
/*проверка размера файла*/						if($size>$maxFileSize){	echo "ощибка размера файла > 10 MB";unlink($_FILES['uploadfile']['tmp_name']);exit;}
												if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)){ echo "Успех";} else {echo "ошибка ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";}
											// closedir ($structure);
}

?>
