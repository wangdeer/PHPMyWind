<?php	require_once(dirname(__FILE__).'/../../inc/config.inc.php');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-6 12:02:48
person: Feng
**************************
*/


//初始化参数
$size  = isset($size)  ? $size  : 0;
$num   = isset($num)   ? $num   : 0;
$input = isset($input) ? $input : '';
$area  = isset($area)  ? $area  : '';
$frame = isset($frame) ? $frame : '';
$title = isset($title) ? $title : '';
$type  = isset($type)  ? $type  : '';


//获取上传文件类型
function GetUpType($type='')
{

	global $cfg_upload_img_type,
		   $cfg_upload_soft_type,
		   $cfg_upload_media_type;


	if($type == 'image')
	{
		$uptype = explode('|',$cfg_upload_img_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}

	else if($type == 'soft')
	{
		$uptype = explode('|',$cfg_upload_soft_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}

	else if($type == 'media')
	{
		$uptype = explode('|',$cfg_upload_media_type);
		$upstr  = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}

	else if($type == 'all')
	{
		$alltype = $cfg_upload_img_type.'|'.$cfg_upload_soft_type.'|'.$cfg_upload_media_type;
		$uptype  = explode('|',$alltype);
		$upstr   = '';
		foreach($uptype as $v)
		{
			if(!empty($v))
			{
				$upstr .= '*.'.$v.';';
			}
		}
		return $upstr;
	}

	else
	{
		return $type;
	}
}


//获取上传文件描述
function GetUpDesc($desc)
{
	if($desc == 'image')      return '图像类型:';

	else if($desc == 'soft')  return '软件类型:';

	else if($desc == 'media') return '媒体类型:';

	else if($desc == 'all')   return '所有类型:';

	else return $desc;
}


//引入水印配置文件
require_once(PHPMYWIND_DATA.'/watermark/watermark.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WebUploader</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="webuploader.html5only.min.js"></script>
<link rel="stylesheet" type="text/css" href="webuploader.css">
</head>
<body>
<script type="text/javascript">

	// 初始化Web Uploader
	var uploader = WebUploader.create({

		// 选完文件后，是否自动上传。
		auto: true,

		// 文件接收服务端。
		server: 'http://webuploader.duapp.com/server/fileupload.php',

		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '#filePicker',

		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});

	// 当有文件添加进来的时候
	uploader.on( 'fileQueued', function( file ) {
		var $li = $(
				'<div id="' + file.id + '" class="file-item thumbnail">' +
					'<img>' +
					'<div class="info">' + file.name + '</div>' +
				'</div>'
				),
			$img = $li.find('img');


		// $list为容器jQuery实例
		$list.append( $li );

		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb( file, function( error, src ) {
			if ( error ) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}

			$img.attr( 'src', src );
		}, thumbnailWidth, thumbnailHeight );
	});

	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress span');

		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<p class="progress"><span></span></p>')
					.appendTo( $li )
					.find('span');
		}

		$percent.css( 'width', percentage * 100 + '%' );
	});

	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file ) {
		$( '#'+file.id ).addClass('upload-state-done');
	});

	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file ) {
		var $li = $( '#'+file.id ),
			$error = $li.find('div.error');

		// 避免重复创建
		if ( !$error.length ) {
			$error = $('<div class="error"></div>').appendTo( $li );
		}

		$error.text('上传失败');
	});

	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress').remove();
	});

</script>
<div id="uploader-demo" class="wu-example">
    <div id="fileList" class="uploader-list">
    </div>
    <div id="filePicker" class="webuploader-container">
		<div class="webuploader-pick">选择图片</div>
		<div id="rt_rt_1f040rmv6onqead15ci6h2rvh4" style="position: absolute; inset: 0px auto auto 0px; width: 94px; height: 44px; overflow: hidden;">
			<input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">
			<label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label>
		</div>
	</div>
</div>
</body>
</html>
