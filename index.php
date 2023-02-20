<?session_start();?>
<html>
<head>
<meta charset="utf-8">
<!--<link rel="icon" href="//92.241.17.70/alterna/img/54.ico" type="image/x-icon">-->
<!--<link rel="shortcut icon" href="//92.241.17.70/alterna/img/54.ico" type="image/x-icon">-->
<body>


<link 		href	= "./css/if.css" 			rel="stylesheet" type="text/css"	/>
<link 		href	= "./css/jquery.alerts.css" 			rel="stylesheet" type="text/css"	/>
<link 		href 	= "./css/jquery.autocomplete.css" 		rel="stylesheet" type="text/css" 	/>
<link 		href 	= "./css/jqueryui.custom.css"			rel="stylesheet" type="text/css" 	/>
<link 		href 	= "./css/style.css"			rel="stylesheet" type="text/css" 	/>
<link 		href 	= "./css/config_tabl_style.css"			rel="stylesheet" type="text/css" 	/>

<script  	src 	= "./js/jquery.min.js"					type="text/javascript">	</script>
<script 	src 	= "./js/jqueryui.custom.js"				type="text/javascript"> </script>
<script  	src 	= "./js/jquery.autocomplete.pack.js"	type="text/javascript"> </script>
<script 	src		= "./js/jquery.alerts.js" 				type="text/javascript"> </script>
<script		src		= "./js/script_pockazka.js"  			type="text/javascript"> </script>

<script		src		= "./js/swfupload/swfupload.js"  		type="text/javascript"> </script>
<script		src		= "./js/swfupload/jquery.swfupload.js"  	type="text/javascript"> </script>

<title>Таблица Консолидации</title>

<script type="text/javascript">

function vigruzka(){

var tbl_sovpad = $('table#sovpad'),
	tbl_ostatki=$('table#ostatki'),
	a=new Array(),
	b=new Array(),
	c=new Array(),
	d=new Array(),
	a1=new Array(),
	b1=new Array(),
	c1=new Array();
	d1=new Array();
	
	tbl_sovpad.find('tr').each(function(i,e){
	name = jQuery(e).find('.name').text();
	ed_izmr = jQuery(e).find('.ed_izmr').text();
	kol_vo = jQuery(e).find('.kol_vo').text();
	});
	
	  tbl_sovpad.each(function(i,tr){
		a.push($('td.name',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));

		b.push($('td.ed_izmr',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));
		
		c.push($('td.kol_vo',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));

		d.push($('td.puti',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));
		
		});

	tbl_ostatki.each(function(i,tr){
	a1.push($('td.name',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));
	
	b1.push($('td.ed_izmr',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));
	
	c1.push($('td.kol_vo',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));

	d1.push($('td.puti',tr).map(function(i,td){
		return $(td).text();
        }).get().join('\t'));
		});

			$.ajax({
  type: "POST",
  url: "upload.php",
  data: "sid=$2a$10$1g$MluiZ0BrByI3saWyE.exHpON79CAzh.HVgxutSRWc4GYfIsr6S",
  error: function(){
	alert('error ajax');
				},
  success: function(msg){
	jQuery('body').css("overflow","hidden");jQuery('body').append('<div class="fon_alert"></div>'); jQuery('.fon_alert').fadeIn(300); 	jQuery.alerts.okButton = '&nbsp;ОК&nbsp;';
	jAlert("<center><h2>>>>"+msg+"<<<</h2><br><nav><ul  style='text-align: left;'>Примечание:<br><li>Выполните обработку файлов по виду материалов;</li></ul></nav><br></center>", 'Внимание', function(r){if(r == true){jQuery('body').css("overflow","visible");jQuery('.fon_alert').removeClass('fon_alert');}}); $('#name_rp').removeClass().addClass('inputRed');
  }
			});
										
};

	


	//функция обработки загрузки загрузки					
function downoload_files() {
		var 
		nam_file='not_name',
		fill_koll = 200,
		format="*.xls;*";
				jQuery('#swfupload_control').swfupload({
		upload_url: "upload.php",
		file_post_name: 'uploadfile',
		file_size_limit : "15 MB",
		file_types : format,
		file_types_description : "Document files",
		file_upload_limit : fill_koll,	//кол-во файлов
		flash_url : "./js/swfupload/swfupload.swf",
		button_image_url : './js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : jQuery('#button')[0],
		// post_params: {"papkaname": ""+red_rashet+"", "id_izd": "0", "fill_koll": ""+fill_koll+""},	//передача переменных
		debug: false
													})												
					.bind('fileQueued', function(event, file){
		
			var listitem='<li id="'+file.id+'" class="ress">'+
				'Фаил: <em class="Name_fill">'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Ожидает загрузки</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			jQuery('#log').append(listitem);
			jQuery('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = jQuery.swfupload.getInstance('#swfupload_control');
				swfu.cancelUpload(file.id);
				jQuery('li#'+file.id).slideUp('fast');
				//блок удаления
				Name_fill=jQuery('#log li#'+file.id).find('em.Name_fill').text();
				// alert(Name_fill);
			});
					// начало загрузки первого в очереди
					jQuery(this).swfupload('startUpload');
			
		
												})
		
									
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Загружаемый фаил '+file.name+' больше установленного ограничения или запрещенного формата');
																		})

		.bind('uploadStart', function(event, file){
			jQuery('#log li#'+file.id).find('p.status').text('Загрузка...');
			jQuery('#log li#'+file.id).find('span.progressvalue').text('0%');
													})
													
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//показать прогресс загрузки
			var percentage=Math.round((bytesLoaded/file.size)*100);
			jQuery('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			jQuery('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
																		})
																		
		.bind('uploadSuccess', function(event, file, serverData){
			var swfu = jQuery.swfupload.getInstance('#swfupload_control');	
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >подробно &raquo;</a>';
			item.addClass('success').find('p.status').html('');
			//jQuery.alerts.okButton = '&nbsp;ОК&nbsp;';jAlert("<center> Messeg: ="+serverData+"= <br><center>", 'Внимание пользователь');
			
			switch (serverData.substring(0, 15)){
			case 'Данный формат з' : swfu.cancelUpload(file.id);jQuery('li#'+file.id).slideUp('fast'); jAlert("<center>!!! Данный формат запрещен!!!<center>", "Error", function(r) {if(r == true){jQuery('.fon_alert').removeClass('fon_alert');jQuery('body').css("overflow","visible");}}); break;	
			case 'Ошибка размера ' : swfu.cancelUpload(file.id);jQuery('li#'+file.id).slideUp('fast'); jAlert("<center>!!! Размер файла превышен лимит в 15 мб !!!<center>", "Error", function(r) {if(r == true){jQuery('.fon_alert').removeClass('fon_alert');jQuery('body').css("overflow","visible");}}); break;	
			case 'Имя изменилось:' : nam_file = serverData.substring(15);jQuery('#log li#'+file.id).find('em.Name_fill').text(nam_file); break;	
			case '' : jAlert("<center>!!! Успешно !!!<center>", 'Успешно'); break;	
			//default: jAlert("<center>!!! Произошла Ошибка Загрузки файла!!! <br>"+serverData+"<center>", 'error'); break;	
												}
			
		
			//alert("Messeg: "+serverData);
																})
																	
																	
		//блок полной загрузки файла
		.bind('uploadComplete', function(event, file){
			
		document.getElementById('auth').style.display='block';

			// Загрузить завершена, перход к следующиму в очереди!!!
			jQuery(this).swfupload('startUpload');
														})
														
										
	};
		$(document).ready(function() { downoload_files() ;	});
</script>
  <style>
    
#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
#log{ margin:0; padding:0; width:280px;}
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px; 
	font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
#log li .progress{ background:#999; width:0%; height:5px; }
#log li p{ margin:0; line-height:18px; }
#log li.success{ border:1px solid #339933; background:#ccf9b9; }
#log li span.cancel{ position:absolute; top:2px; right:2px; width:10px; height:10px; 
	background:url('./js/swfupload/cancel.png') no-repeat; cursor:pointer; background-size: 10px 10px;}
#log li span.cancel:hover{ position:absolute; top:3px; right:3px; width:10px; height:10px; 
	background:url('./js/swfupload/cancel.png') no-repeat; cursor:pointer; background-size: 10px 10px;}
#log li span.cancel:active{ position:absolute; top:4px; right:4px; width:10px; height:10px; 
	background:url('./js/swfupload/cancel.png') no-repeat; cursor:pointer; background-size: 10px 10px;}
	
  </style>
<?
error_reporting(0);
set_time_limit(0);

//функци поиска всех файлов в директории "for_botcman/file/"
function GetListFiles($folder,$type,&$all_files){
//$m=0;
    $fp=opendir($folder);
	   while($cv_file=readdir($fp)) {
		   foreach ($type as $val){
	  if(strstr($cv_file,$val,true)){
        if(is_file($folder."/".$cv_file)) {
			//$txt = explode('.', $cv_file);
	//$m++;
	//переименовать файл
			//rename($folder.'/'.$cv_file, $folder.'/'.$m.".".$txt[1]);	
            $all_files[]=$folder."/".$cv_file;
        }elseif($cv_file!="." && $cv_file!=".." && is_dir($folder."/".$cv_file)){
            GetListFiles($folder."/".$cv_file,$type,$all_files);
        }
		
	   }						}
		  
    }

    closedir($fp);
}

//функци удаления всех файлов "for_botcman/file/"
function DellListFiles($folder,&$all_files){

    $fp=opendir($folder);
	   while($cv_file=readdir($fp)) {

        if(is_file($folder."/".$cv_file)) {
			$name = $folder."/".$cv_file;
            $all_files[]=$name;
			unlink($name);
        }elseif($cv_file!="." && $cv_file!=".." && is_dir($folder."/".$cv_file)){
            GetListFiles($folder."/".$cv_file,$all_files);
        }
		 
    }

    closedir($fp);
}
// типы обрабатываемых файлов
$type=array('.xls');
$child_path='/consolidation';
 switch (true) {
	 case $_POST['start'] :
	 session_unset();    // Unset все переменные сессии.
	//создание массива для найденных списков файлов
$count_file=array();
GetListFiles($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile',$type,$count_file);
if(count($count_file) == 0){
goto down;
}
echo '
<div id="style_info_bar">
	<div class="demo-wrapper html5-progress-bar" style ="top: 35%;	left: 30%;	position: absolute; ">
			<div id="progress-name" ></div>
			<div class="progress-bar-wrapper" style="margin: 8px auto 0;">
			<progress id="progressbr" value="0" max="100"></progress>
			<span class="progress-value" id="progress-proc">0%</span>
			<div id="progress-time" style="margin: 8px auto 0;">0</div>
		</div>
	</div>
</div>
';


function getmicrotime()
  {
  $mtime = microtime();
  $mtime = explode(" ",$mtime);
  $mtime = $mtime[1] + $mtime[0];
  return($mtime);
  }
  
function time_sent($end,$str){
	
if(floor(($end - $str)) > 59){
$sk = ($end - $str)/60;
 $tims = explode('.', $sk);
 $sec = substr($tims[1],0,2);
if($sec > 59){$sec = $sec - 60;}
$m = floor(($end - $str)/60);
							
							}else{
								
			$m = floor(($end - $str)/60);			
			$sec = floor(($end - $str));
			
					}
					
			return 	$m.' мин. '.$sec.' сек.';
									}
//function CopyLine($num)
//{
// flush();
//
//    for($i = 1;$i<$num;$i++)
//    {
//        $tmp = $tmp ."|";
//    }
//    return $tmp;
//}

//функци вывода времени обработки в прогресс бара
function time_progress($id,$count,$mt)
{
		//вывод прогресбар выполнени кода
	return '<script> 
    document.getElementById("progress-proc").innerHTML = "'.floor((($id*100)/$count)).' %"; 
	document.getElementById("progressbr").value = "'.floor((($id*100)/$count)).'";
	document.getElementById("progress-time").innerHTML  = "Время выполнения: '.$mt.'"; 
    </script>'; 
	
		// return '<script> 
    // document.all.proc.value = "'.round((($id*100)/$count),1).' %"; 
    // document.all.line.innerHTML = "'.CopyLine(($id*100)/$count).'"; 
    // document.all.tim.innerHTML = "Врем выполнения: '.$mt.' мин.'.$sc.'сек."; 
    // </script>'; 
}
//функци сравнивани массива $name по пришедшему атрибуту $vl
function IsInArray($name , $vl)
{
 // определем длину массива
  $count=count($name);
  //переменна идентификатор
  $j=0;
  // сам поиск
 while ($j<=$count)
  {
   if ($name[$j]==$vl) // если нашли
      {
	  //запис в массив найденых совпадений
	 $serch[$j]=$vl;
	/// return $j; 
	//	break; 
      }
   $j++;
  }
  //возвращаем массив
  return $serch;
}
	//запуск обработки скрипта ограничен до 3 минут
$tstart = getmicrotime();
//создание массива для найденных списков файлов
$all_files=array();
GetListFiles($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile',$type,$all_files);
$files_input = array();
// Обрезать путь в названии файла
$setting_file_name = strlen($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile/');
foreach ($all_files as $id_f => $val_f){
	if( $val_f != '' ){
	$files_input[]=mb_substr($val_f, $setting_file_name);
	}	
		}
	
//echo "<center>Количество найденных файлов: ".count($files_input)."<br></center>";
echo '<script>document.getElementById("progress-name").innerHTML = "Обработка документов";</script>';
// подключение обработки спецификацииы
require_once $_SERVER['DOCUMENT_ROOT'].$child_path.'/php_excel/excel_reader2.php';
// объявления массива
$col_name_mtr = array();
$col_type_izm = array();
$col_kol_mtr  = array();
$ms = array();
$sleep_time = 0;
$kol_fill = count($files_input);
$processed_file = array();
// вывод выгрузки в xls файл
// echo count($ms['id_fille']);
	// обработка массива списка файлов
					for ($id_f = 0; $id_f <= $kol_fill; ++ $id_f){

$error_processing=null;
							// просчет времени обработки
$tend = getmicrotime();
$time = time_sent($tend,$tstart);
// вывод времени выполнения прогресс бара
echo time_progress($id_f,$kol_fill,$time);	
// название файла
	$val_f = $files_input[$id_f];
// сообщение в прогрессбаре	
	echo '<script>document.getElementById("progress-name").innerHTML = "Обработка Файла: '.($id_f).'/'.count($files_input).'>>'.$val_f.'";</script>';
	ob_flush();flush();sleep(0.1);
if(empty($val_f)){ break; }
// задать минимальный размер файла 5 МБ
$minFileSize = 5 * 1024 * 1024;
// размер файла
$filesize = filesize($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile/'.$val_f);
//print_r($filesize);
// проверить чтоб файл был больше 4 мб 
// if($filesize<=$maxFileSize){ echo "<b>Файл: ".$val_f." <i style = 'color:red;'>!!!Не обработан << не подходит по размеру!!!</i> </b><br>"; break; }
if($filesize<=$minFileSize){ $error_processing='Размер файла меньше установленного шаблона '; goto end; }

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('cp1251');
$data->read($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile/'.$val_f);
// проверить на наличие 4 листов в файле xls
 // if(count($data->boundsheets)!=4){ echo "<b>Файл: ".$val_f." <i style = 'color:red;'>!!!Не обработан << Нет страницы с данными для обработки!!!</i> </b><br>"; break 1; }

 if(count($data->boundsheets)!=4){ $error_processing='В файле не обнаружено 4 листа, согласно  установленного шаблона '; goto end; }
//обрабатываема страница в exel счет начинаетс с 3
$list=3;
				$this_cell_colspan = $data->sheets[$list]['numRows']; // строки
				$this_cell_rowspan = $data->sheets[$list]['numCols']; // колонки
// присваивание колонок
$col_1 = mb_convert_encoding($data->val(9,1,$list), "UTF-8", "CP1251");		// № п/п
$col_2 = mb_convert_encoding($data->val(9,2,$list), "UTF-8", "CP1251");	// Наименование
$col_3 = mb_convert_encoding($data->val(9,3,$list), "UTF-8", "CP1251");		// ед.изм.
$col_4 = mb_convert_encoding($data->val(9,4,$list), "UTF-8", "CP1251");		// Кол-во едениц
$kol_vo = mb_convert_encoding($data->val(8,4,$list), "UTF-8", "CP1251");		// количество изделий

		// проверка проходит ли файл по шаблону
	if($col_1 == "№ п/п" && $col_2=='Наименование' && $col_3=="ед.изм." && $col_4=="Кол-во" && ($kol_vo>0 || $kol_vo!='' ) ){
	$processed_file[] = $files_input[$id_f];
		// обработка строк в файле
	for ($col = 10; $col <= $this_cell_colspan; ++ $col)
			{
	$nm = mb_convert_encoding($data->val($col,2,$list), "UTF-8", "CP1251");	//название
	$ed = mb_convert_encoding($data->val($col,3,$list), "UTF-8", "CP1251");	//ед.ихм.
	$kl = mb_convert_encoding($data->val($col,4,$list), "UTF-8", "CP1251");	//кол-во
	//проверка на пустые массивы
	if(!empty($nm) && !empty($ed) && !empty($kl)){
	// присвоение типа переменной
	if (!preg_match("/./i", $kl)){$kl = intval($kl);}else{$kl=floatval($kl);}
	// $col_name_mtr[] = $data->val($col,2,$list);
	// $col_type_izm[] = $data->val($col,3,$list);
	// $col_kol_mtr[] = $kl;
	
	$ms['id_fille'][]		= $val_f;
	$ms['col_name_mtr'][]	= mb_convert_encoding($data->val($col,2,$list), "UTF-8", "CP1251");
	$ms['col_type_izm'][]	= mb_convert_encoding($data->val($col,3,$list), "UTF-8", "CP1251");
	$ms['col_kol_mtr'][]	= $kl*$kol_vo;
	// help
	//echo 'путь: '.$val_f.'===='.$data->val($col,2,$list).'=='.$kl*$kol_vo.'<br>';	
											}
	// завершить обработку массива										
	if($nm=='ЦЕНА:') break;
	
	// вывод времени выполнения прогресс бара
	// echo time_progress($col,$this_cell_colspan,$min,$sec);	
		//остановка выполения скрипта
	// ob_flush();flush();sleep(1);
					}
		//echo $put;
		//echo "<br>".$col_1.">>".$col_2.">>".$col_3.">>".$col_4.">>".$kol_vo."<br>";
						}else{
					
switch (true) {
			case ($col_1 != "№ п/п" &&  $col_2 != 'Наименование' && $col_3 != "ед.изм." && $col_4 != "Кол-во") : $error_processing = "Не найдена страница с <Расчетом изделий>"; break;	
			case $col_1 != "№ п/п" : 		$error_processing = "Не найдена ячейка с <№ п/п> == (Позиция:А9)"; break;	
			case $col_2!='Наименование' : 	$error_processing = "Не найдена ячейка с <Наименование> == (Позиция:В9)"; break;	
			case $col_3!="ед.изм." : 		$error_processing = "Не найдена ячейка с <ед.изм.> == (Позиция:C9)"; break;	
			case $col_4!="Кол-во" : 		$error_processing = "Не найдена ячейка с <Кол-во> == (Позиция:D9)"; break;	
			case $kol_vo == null : 			$error_processing = "Не найдена ячейка с <Кол-во изделий в проекте> == (Позиция:D8)"; break;	
			default  : 						$error_processing = "Не известная ошибка"; break;	
				}
		// очистить переменные
		$col_1 = null; $col_2 = null; $col_3 = null; $col_4 = null; $kol_vo = null;
		
							end:
						echo "<b>Файл: ".$val_f." <i style = 'color:red;'>!!!Не обработан!!!</i> <i style = 'color:blue;'>---> $error_processing</i> </b><br>";
						}													}
		// завершена обработка файлов
$tend = getmicrotime();
$time = time_sent($tend,$tstart);
echo '<script>document.getElementById("progress-name").innerHTML = "Завершена обработка файлов";
	  document.getElementById("progress-time").innerHTML  = "Время выполнения: '.$time.' мин.";</script>';	

		//остановка выполения скрипта
ob_flush();flush();sleep($sleep_time);


	//обработка найденных позиций
	if(isset($ms['col_name_mtr']) or !empty($ms['col_name_mtr'])){
$tend = getmicrotime();
$time = time_sent($tend,$tstart);	
		// завершена обработка файлов
echo '<script>document.getElementById("progress-name").innerHTML = "Обработка найденых данных"; 
				document.getElementById("progress-time").innerHTML  = "Время выполнения: '.$time.' мин.";</script>';	
ob_flush();flush();sleep($sleep_time); //остановка выполения скрипта
$search = array_count_values($ms['col_name_mtr']); //$search массив найденных совпадении
$u=0;
 foreach ($search as $name_search => $count_search){
								// просчет времени обработки
$tend = getmicrotime();
$time = time_sent($tend,$tstart);
	//$count_search колличество совпадении
	//$name_search идентификатор массива или название 
			 $u++;

// найденное совпадение $name_search;
// искат в массиве $ms['col_name_mtr']
// которые > 1			 
			 		if($count_search > 1 && !empty($name_search)){

		$serch=array();
		$serch=IsInArray($ms['col_name_mtr'],$name_search); // поиск обнаруженых совпадений
		$d=1;
		$sum=0;
		$ss=array();
		
		//обработка всех найденных совпадений с расчетом суммы количества по каждому материалу
		foreach ($serch as $id => $val){
		$d++;
		//сложение кол-во найденных материалов
		$sum=$ms['col_kol_mtr'][$id]+$sum;
		$ss[]=$ms['id_fille'][$id];
										}

		$rra=array_unique($ss);
		sort($rra);
		$putis=implode("//<br>", $rra);							
		$id=array_search($name_search, $ms['col_name_mtr'], true);	
		
		//проверка ест ли точка в переменной и округлит до двух символов после заптой
			if (preg_match("/./i", $sum)){$sum = round($sum,2);}	
	$nem[$u]=$name_search;
	$edi[$u]=$ms['col_type_izm'][$id];
	$ksl[$u]=$sum;
	$put[$u]=$putis;
									
									}else{
			
			//обработка оставшихс материалов
			$id=array_search($name_search, $ms['col_name_mtr'], true);
			$kolv=$ms['col_kol_mtr'][$id];
			if (preg_match("/./i", $ms['col_kol_mtr'][$id])){$kolv = round($ms['col_kol_mtr'][$id],2);}
			$names[]=$ms['col_name_mtr'][$id];
			$ed_iz[]=$ms['col_type_izm'][$id];
			$kl_vo[]=$kolv;
			$puti[]=$ms['id_fille'][$id];
			
			}										}
			
			asort($nem); asort($names);		// сортировка массива

//echo '<br>'.print_r($search);
// $group = array(	
// 1 => 'ЛДСП',
// 2 => 'ХДФ',
// 2 => 'МДФ',
// 2 => 'Фанера',
// 2 => 'Кромка',
// 2 => 'Окраска',
// 2 => 'Шпон',
// 2 => 'Пластик',
// 2 => 'Стекло',
// );
// $type = ;
// Сортировка массива asort('')

echo "Количество найденых материалов: ".(count($names)+count($nem));
echo "<br>Из них совпадений: ".count($nem);
echo "<br>Одиночные материалы: ".count($names);
echo "<br><b>Время выполнения: ".$time."</b>";
echo "<br><b>Обработанных файлов: ".(count($processed_file).'/'.$kol_fill)."</b>";
 
if(count($processed_file)>0){ echo '<center><input type="button" id="vigruz" value="выгрузка в xls" onClick="vigruzka();"/></center> <br>'; }

$matches_array = array();
$differences_array = array();

if(!empty($nem)){
echo "<table border=0 id='sovpad' ><caption>Таблица Найденных Совпадений</caption>";
echo "<tr><th>№</th><th>Наименование</th><th>ед.измр.</th><th>Кол-во</th><th>Расположение</th></tr>";
$v=0;

			foreach($nem as $id => $value){
											// просчет времени обработки
$tend = getmicrotime();
$time = time_sent($tend,$tstart);
			$v++;
echo "<tr><td>".$v."</td><td class='name'>".$value."</td><td class='ed_izmr'>".$edi[$id]."</td><td class='kol_vo'>".$ksl[$id]."</td><td class='puti'>".$put[$id]."</td></tr>";
// массив совпадений
$matches_array[]=array(
	'name'=>$value,
	'ed_izmr' => $edi[$id],
	'kol_vo' => $ksl[$id],
	'puti' => $put[$id]
			);
}
	echo "</table>";}else{echo "<br><i style = 'color:red;'>!!!Совпадений не найдено!!!</i>";}
echo "</td><td>";
if(!empty($names)){
	echo "<br><br><table border=0 id='ostatki'><caption>Таблица Оставшийся Совпадений</caption>";
	echo "<tr><th>№</th><th>Наименование</th><th>ед.измр.</th><th>Кол-во</th><th>Расположение</th></tr>";
$v=0;
			foreach($names as $id => $value){
											// просчет времени обработки
$tend = getmicrotime();
$time = time_sent($tend,$tstart);
			$v++;
echo "<tr><td>".$v."</td><td class='name'>".$value."</td><td class='ed_izmr'>".$ed_iz[$id]."</td><td class='kol_vo'>".$kl_vo[$id]."</td><td class='puti'>".$puti[$id]."</td></tr>";
// массив оставшихся элементов
$differences_array[]=array(
	'name'=>$value,
	'ed_izmr' => $ed_iz[$id],
	'kol_vo' => $kl_vo[$id],
	'puti' => $puti[$id]
				);
}
	echo "</table>";}else{echo "<br><i style = 'color:red;'>!!!Оставшийся Элементов нет!!!</i>";}
echo "</td></tr></table>";
	}

$_SESSION['matches_array'] = $matches_array;
$_SESSION['differences_array'] = $differences_array;

echo "<script>document.getElementById('vigruz').style.display='block';
		document.getElementById('progress-name').innerHTML = 'ВЫПОЛНЕНО';
		document.getElementById('progress-time').innerHTML  = 'Время выполнения: ".$time."';
		document.getElementById('style_info_bar').style.display = 'none';
		</script>";
		
ob_flush();flush();sleep($sleep_time); //остановка выполения скрипта
 
	 echo "<script> document.getElementById('style_info_bar').style.display='none'; </script>";
	 break;
	 
	  case $_POST['clear_file'] :
	  
	  // очистка файлов в директории uploadfile
	 $puti = $_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile';
	 DellListFiles($puti,$dell_file);
	 session_unset();    // Unset все переменные сессии.
	 session_destroy();  // Наконец, разрушить сессию.

	  goto down;
	  break;
	 
	 default: 
	 down:

	 
	 			echo "<center>
					<div id='swfupload_control' style ='display:none;'>
					<p align='center'>
					Загрузка 200 файлов в фарматах(xls,xlsx),
					<br> максимум размер файла 10 MB
					</p>
					<center>
					<input type='button' id='button' /></center><ol id='log'></ol></div>
				 </center>
					<br>";
			echo "<center>
					<form id='auth' action='' method='post' style ='display:none;'> 
					<input type='submit' name='start' value='Запуск!'>   
					<input type='submit' name='clear_file' value='Очистить реестр файлов'> 
					</form>
				 </center>";
			
	 		$count_file=array();
		GetListFiles($_SERVER['DOCUMENT_ROOT'].$child_path.'/uploadfile',$type,$count_file);
		if(count($count_file) == 0){
			echo "<script> document.getElementById('swfupload_control').style.display='block'; </script>";
		}else{
			echo "<script> document.getElementById('auth').style.display='block'; </script>";
		}
	 break;
 }

?>
</head>
</body>
</html>



