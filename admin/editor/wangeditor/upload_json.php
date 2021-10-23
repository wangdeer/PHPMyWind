<?php	require_once(dirname(__FILE__).'/../../inc/config.inc.php');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2012-7-24 11:16:02
person: Feng
**************************
*/


require_once('JSON.php');


//有上传文件时
if(!empty($_FILES))
{
	//引入上传类
	require_once(PHPMYWIND_DATA.'/httpfile/upload.class.php');

	$filesTmp = [];

	foreach ($_FILES as $k => $v) {
		
		$upload_info_tmp = UploadFile($k, 'true');

		if(is_array($upload_info_tmp))
		{
			$filesTmp[] = [
				'url'	=> '../'.$upload_info_tmp[2],
				'alt'	=> $upload_info_tmp[0],
				'href'	=> ''
			];
		} else {
			alert($upload_info);
			exit();
		}
	}

	if (!empty($filesTmp)) {
		header('Content-type: application/json; charset=UTF-8');
		$json = new Services_JSON();
		
		echo $json->encode(array(
			'errno' => 0,
			'data'	=> $filesTmp,
		));
		exit();
	}
}

function alert($msg)
{
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit();
}
?>
