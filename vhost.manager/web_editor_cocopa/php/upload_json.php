<?php
/**
 * KindEditor PHP
 * 
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 * 
 */
require_once '../../config.php';
require_once 'JSON.php';
//require_once '../../class/ftp.php';//ftp类图片同步而用

//文件保存目录路径
$save_path = $config_upload_root.'upload/images/';
//文件保存目录URL
$save_url = $config_upload_url.'upload/images/';
//定义允许上传的文件扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
//最大文件大小
$max_size = 1000000;

//上传图片 支持按照月份 分类文件夹储存
if(!file_exists($save_path . 'f_' . date("Ym"))){
 mkdir($save_path . 'f_' . date("Ym"),0777);
}
$save_path = $config_upload_root.'upload/images/f_' . date("Ym").'/';
$save_url = $config_upload_url.'upload/images/f_' . date("Ym").'/';


//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("파일을 선택 하십시오.");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("업로드 폴더가 존재 하지  않습니다.");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("업로드 폴더가 사용권한이 없습니다.");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("임시파일이 업도르파일이 아닐수도 있습니다.");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("업로드 용량이 너무 큽니다.");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr) === false) {
		alert("허용되는 파일 격식이 아닙니다. 확인하여 주십시오.");
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("업로드 실패하였습니다.");
	}
	/*以下是多服务器图片同步的代码*/
	if($config_ftp_open=="1")//查是否开启多台服务器同步 0为关闭 1为开启
	{
		if(file_exists($file_path))
		{
			
			$ftp = new ftp($config_ftp_ip,$config_ftp_port,$config_ftp_user,$config_ftp_pass);// 打开FTP连接 ip,端口,帐号,密码
			$ftp->up_file($file_path,"/images/f_". date("Ym")."/".$new_file_name);                // 上传文件 
			$ftp->close();                                                    // 关闭FTP连接 
		}
	}
	/*到此结算同步*/
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;
	
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>