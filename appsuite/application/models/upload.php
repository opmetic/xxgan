<?php
/**
 * 上传类
 *
 * @package upload
 * @author hyb<hyb@icbuy.net>
 * @version $Id: upload.php,v 1.2 2008/03/14 06:24:37 hyb Exp $
 * @copyright (c) 2008 Icbuy Group
 */


/*示例
include_once(LIBS . 'upload.' . $phpEx);

$upload = new upload(array(
'filename' => $filename,
'save_file' => $save_file,
'limit_exts' => true,
'allow_exts' => 'jpg|gif|png',
'allow_mark' => 1,
'mark_type' => 0,
'mark_words' => 'icbuy.net')
);


//用$upload->get_error()获取错误信息
//返回0表示没有指定输入文件的文件名
//返回1表示没有指定输出文件的文件名及其路径
//返回2表示文件太大或太小
//返回3表示文件类型是不允许的
//返回4表示文字水印的文字没有提供
//返回5表示图片水印的图片没有提供
//返回true表示可以上传

switch ( $my_error = $upload->get_error() )
{
case 0:
echo '没有指定输入文件的文件名';
break;
case 1:
echo '指定输出文件的文件名及其路径';
break;
case 2:
echo '文件太大或太小';
break;
case 3:
echo '文件类型是不允许的';
break;
case 4:
echo '文字水印的文字没有提供';
break;
case 5:
echo '图片水印的图片没有提供';
break;
default:
$upload_now = $upload->upload_now();
//返回true上传成功
//返回false上传失败
//返回1表示当图片高度和宽度不符合指定大小

if ( $upload_now == true)
{
echo '上传成功';
}
else
{
switch ( $my_upload_error = $upload->get_upload_error() )
{
case 1:
echo '是网页，不允许上传网页';
break;
case 2:
echo '临时文件不存在';
break;
case 3:
echo '图片高度和宽度不符合指定大小';
break;
}
}

break;
}

*/

class upload
{

	var $_filename = ''; //输入文件的文件名(也可以直接是文件数据)
	var $_save_file = ''; //输出文件名，包括路径

	var $_input_type = ''; //输入类型
	var $_output_type = ''; //输出类型

	var $_limit_size = false; //是否限制文件大小
	var $_max_size = 1024000; //文件允许的最大大小,bt
	var $_min_size = 10; //文件允许的最小大小,bt

	var $_force_gd_gif = false;  //是否使用gd强制处理gif图片，默认是false不处理gif图片（因为用gd会把gif动画处理成静态的），true时强制处理

	var $_limit_exts = false; //是否限制文件类型
	var $_allow_exts = 'jpg|gif|png|bmp'; //允许类型

	var $_limit_height_width = false;  //是否限制图片高和宽
	var $_max_height = 400; //图片最大高度,px
	var $_min_height = 10; //图片最小高度,px
	var $_max_width = 500; //图片最大宽度,px
	var $_min_width = 10; //图片最小宽度,px

	var $_allow_force = false;  //是否强制图片大小
	var $_force_type = 1;  //强制类型，0强制所有图片，1强制不符合高和宽要求的
	var $_force_mode = 0; //强制模式，0固定大小，1等比缩放，当$_force_type = 0时，这个必须等于0
	var $_force_height = 400; //强制最大高度,0表示不强制高度
	var $_force_width = 500; //强制最大宽度，0表示不强制宽度

	var $_image_quality = 100; //jpeg文件质量

	var $_allow_mark = 1; //是否加水印，0不加，1加
	var $_mark_type = 0; //水印类型，0文字水印，1图片水印
	var $_mark_words = ''; //水印文字
	var $_words_size = 5; //水印文字大小
	var $_words_angle = 0; //水印文字角度
	var $_words_color = 'cccccc'; //水印颜色
	var $_fontfile = 'arial.ttf';  //水印字体
	var $_mark_image = ''; //水印图片名和路径
	var $_image_h = 60; //水印图片高度
	var $_image_w = 120; //水印图片宽度
	var $_image_rate = 90; //水印透明度
	var $_del_color = 'FFFFFF'; //过滤水印图片的颜色
	var $_mark_place = 0; //水印位置，0表示用具体数字定位(即用$_mark_x和$_mark_y)，1左上，2正上，3右上，4左中，5正中，6右中，7左下，8正下，9右下
	var $_mark_x = 30; //水印x坐标
	var $_mark_y = 30; //水印y坐标

	var $_error = 100; //错误
	var $_upload_error = 0; //上传时错误

	var $_upload_mode = 1; //上传方式，1为使用move_uploaded_file，2为使用copy

	/**
     * 控制参数
     *
     * -------------------------------------------------------------------------
	 * - filename	(array):	输入文件的文件名(也可以直接是文件数据) 
	 * - save_file	(string):	输出文件名，包括路径
	 *
	 * - input_type	(string):	输入类型
	 * - output_type	(string):	输出类型
	 *
	 * - limit_size	(bool):	是否限制文件大小
	 * - max_size	(int):	文件允许的最大大小(单位bt),102400
	 * - min_size	(int):	文件允许的最小大小(单位bt),10
	 *
	 * - force_gd_gif (bool): 是否使用gd强制处理gif图片，默认是false不处理gif图片（因为用gd会把gif动画处理成静态的），true时强制处理
	 *
	 * - limit_exts	(bool):	是否限制文件类型
	 * - allow_exts	(string):	允许类型'jpg|gif|png|bmp'
	 *
	 * - limit_height_width	(bool):	是否限制图片高和宽
	 * - max_height	(int):	图片最大高度,px
	 * - min_height	(int):	图片最小高度,px
	 * - max_width	(int):	图片最大宽度,px
	 * - min_width	(int):	图片最小宽度,px
	 *
	 * - allow_force	(bool):	是否强制图片大小
	 * - force_type	(int):	强制类型，0强制所有图片，1强制不符合高和宽要求的
	 * - force_mode	(int):	强制模式，0固定大小，1等比缩放，当$_force_type = 0时，这个必须等于0
	 * - force_height	(int):	强制最大高度,0表示不强制高度
	 * - force_width	(int):	强制最大宽度，0表示不强制宽度
	 *
	 * - image_quality	(int):	jpeg文件质量,0-120间的数值
	 *
	 * - allow_mark	(int):	是否加水印，0不加，1加
	 * - mark_type	(int):	水印类型，0文字水印，1图片水印
	 * - mark_words	(string):	水印文字
	 * - words_size	(int):	水印文字大小,px,,加TTF文字，可惜服务器不支持，暂停该功能,该值现在为1-5的数值
	 * - words_angle	(int):	水印文字角度,加TTF文字，可惜服务器不支持，暂停该功能,该值为1时为纵排，否则横排
	 * - words_color	(string):	水印颜色 'cccccc'
	 * - fontfile	(string):	水印字体'simhei.ttf'
	 * - mark_image	(string):	水印图片名和路径
	 * - image_h	(int):	水印图片高度
	 * - image_w	(int):	水印图片宽度
	 * - image_rate	(int):	水印透明度
	 * - del_color	(string):	过滤水印图片的颜色'FFFFFF'
	 * - mark_place	(int):	水印位置，0表示用具体数字定位(即用mark_x和mark_y)，1左上，2正上，3右上，4左中，5正中，6右中，7左下，8正下，9右下
	 * - mark_x	(int):	水印x坐标 
	 * - mark_y	(int):	水印y坐标 
	 * - upload_mode (int): 上传方式，1为使用move_uploaded_file，2为使用copy
     *
     * @param mixed $options  array()  
     *                          
     */
	function upload( $options = array() )
	{
		$this->_error = 100;

		if ( isset($options['filename']) )
		{
			$this->_filename =  $options['filename'];
		}
		else
		{
			$this->_error = 0;  //返回0表示没有指定输入文件的文件名
			return true;
		}

		if ( isset($options['save_file']) )
		{
			$this->_save_file =  $options['save_file'];
		}
		else
		{
			$this->_error = 1;  //返回1表示没有指定输出文件的文件名及其路径
			return true;
		}

		$this->_limit_size =  ( isset($options['limit_size']) ) ? $options['limit_size'] : false;
		$this->_max_size =  ( isset($options['max_size']) ) ? $options['max_size'] : 1024000;
		$this->_min_size =  ( isset($options['min_size']) ) ? $options['min_size'] : 10;

		if ( $this->_limit_size == true )
		{
			if ( $this->_filename['size'] > $this->_max_size || $this->_filename['size'] < $this->_min_size )
			{
				$this->_error = 2; //返回2表示文件太大或太小
				return true;
			}
		}

		$this->_force_gd_gif = ( isset($options['force_gd_gif']) ) ? $options['force_gd_gif'] : false;

		$this->_limit_exts =  ( isset($options['limit_exts']) ) ? $options['limit_exts'] : false;
		$this->_allow_exts =  ( isset($options['allow_exts']) ) ? $options['allow_exts'] : 'jpg|gif|png|bmp';

		$this->_input_type = strtolower($this->get_file_exts($this->_filename['name']));
		$this->_output_type = strtolower($this->get_file_exts($this->_save_file));

		if ( $this->_limit_exts == true )
		{
			if ( !preg_match("/" . $this->_input_type . "/i", $this->_allow_exts) )
			{
				$this->_error = 3; //返回3表示文件类型是不允许的
				return true;
			}
		}

		$this->_input_type = ( $this->_input_type == 'jpg' ) ? 'jpeg' : $this->_input_type;
		$this->_output_type = ( $this->_output_type == 'jpg' ) ? 'jpeg' : $this->_output_type;

		$this->_input_type = ( $this->_input_type == 'bmp' ) ? 'jpeg' : $this->_input_type;
		$this->_output_type = ( $this->_output_type == 'bmp' ) ? 'jpeg' : $this->_output_type;

		$this->_limit_height_width =  ( isset($options['limit_height_width']) ) ? $options['limit_height_width'] : false;
		$this->_max_height =  ( isset($options['max_height']) ) ? $options['max_height'] : 400;
		$this->_min_height =  ( isset($options['min_height']) ) ? $options['min_height'] : 10;
		$this->_max_width =  ( isset($options['max_width']) ) ? $options['max_width'] : 500;
		$this->_min_width =  ( isset($options['min_width']) ) ? $options['min_width'] : 10;

		$this->_allow_force =  ( isset($options['allow_force']) ) ? $options['allow_force'] : false;
		$this->_force_type  =  ( isset($options['force_type']) ) ? $options['force_type'] : 1;
		$this->_force_mode  =  ( isset($options['force_mode']) ) ? $options['force_mode'] : 0;
		$this->_force_height =  ( isset($options['force_height']) ) ? $options['force_height'] : 400;
		$this->_force_width =  ( isset($options['force_width']) ) ? $options['force_width'] : 500;
		$this->_force_mode = ( $this->_force_type == 0 ) ? 0 : $this->_force_mode;

		$this->_image_quality =  ( isset($options['image_quality']) ) ? $options['image_quality'] : 100;

		$this->_allow_mark =  ( isset($options['allow_mark']) ) ? $options['allow_mark'] : 1;
		$this->_mark_type =  ( isset($options['mark_type']) ) ? $options['mark_type'] : 0;
		$this->_mark_words =  ( isset($options['mark_words']) ) ? $options['mark_words'] : '';
		$this->_words_size =  ( isset($options['words_size']) ) ? $options['words_size'] : 5;
		$this->_fontfile =  ( isset($options['fontfile']) ) ? $options['fontfile'] : 'arial.ttf';
		$this->_words_angle =  ( isset($options['words_angle']) ) ? $options['words_angle'] : 0;
		$this->_words_color =  ( isset($options['words_color']) ) ? $options['words_color'] : "cccccc";
		$this->_mark_image =  ( isset($options['mark_image']) ) ? $options['mark_image'] : '';

		$this->_image_h =  ( isset($options['image_h']) ) ? $options['image_h'] : 60;
		$this->_image_w =  ( isset($options['image_w']) ) ? $options['image_w'] : 120;

		$this->_image_rate =  ( isset($options['image_rate']) ) ? $options['image_rate'] : 90;
		$this->_del_color =  ( isset($options['del_color']) ) ? $options['del_color'] : 'FFFFFF';
		$this->_mark_place =  ( isset($options['mark_place']) ) ? $options['mark_place'] : 0;
		$this->_mark_x =  ( isset($options['mark_x']) ) ? $options['mark_x'] : 30;
		$this->_mark_y =  ( isset($options['mark_y']) ) ? $options['mark_y'] : 30;

		if ( $this->_allow_mark && $this->_mark_type == 0 && empty($this->_mark_words) )
		{
			$this->_error = 4; //返回4表示文字水印的文字没有提供
			return true;
		}

		if ( $this->_allow_mark && $this->_mark_type == 1 && empty($this->_mark_image) )
		{
			$this->_error = 5; //返回5表示图片水印的图片没有提供
			return true;
		}

		if ( $this->_allow_mark && $this->_mark_type == 1 )
		{
			$wimage_data_bb  =  GetImageSize($this->_mark_image);
			switch($wimage_data_bb[2])
			{
				case  1:
					$wimage_bb = @ImageCreateFromGIF($this->_mark_image);
					break;
				case  2:
					$wimage_bb = @ImageCreateFromJPEG($this->_mark_image);
					break;
				default:
					$wimage_bb = @ImageCreateFromPNG($this->_mark_image);
					break;
			}

			$this->_image_w = ImageSX($wimage_bb);
			$this->_image_h = ImageSY($wimage_bb);
			@ImageDestroy($wimage_bb);
		}

		$this->_upload_error = 0;
		$this->_upload_mode =  ( isset($options['upload_mode']) ) ? $options['upload_mode'] : 1;
	}

	function get_file_exts($myfilename)
	{
		$mypos = strrpos($myfilename, '.');
		$exts = substr($myfilename, $mypos + 1, (strlen($myfilename) - $mypos - 1));
		return $exts;
	}

	function get_error()
	{
		return $this->_error;
	}

	function get_upload_error()
	{
		return $this->_upload_error;
	}

	function upload_now()
	{
		if ( @preg_match("/^http:\/\//i", $this->_filename) ) //如果是远程的文件
		{
			$this->_input_type = strtolower($this->get_file_exts($this->_filename));
			$this->_input_type = ( $this->_input_type == 'jpg' ) ? 'jpeg' : $this->_input_type;
			$this->_output_type = $this->_input_type;
			if ( @preg_match("/" . $this->_input_type . "/i", 'htm|html|php|asp|js|jsp|xml') )  //如果是网页
			{
				$this->_upload_error = 1;
				return false;  //不上传网页
			}
			else
			{
				$fp_src = fopen($this->_filename, 'rb');
				$fp_dst = fopen($this->_save_file, 'wb');
				while ( $my_buffer = fgets($fp_src, 4096) )
				{
					fwrite($fp_dst, $my_buffer, 4096);
				}
				fclose($fp_src);
				fclose($fp_dst);
			}

		}
		else
		{
			if ( $this->_upload_mode == 2 )
			{
				if ( !copy($this->_filename['tmp_name'], $this->_save_file) )
				{
					$this->_upload_error = 2;
					return false;  //上传失败
				}
			}
			else
			{
				if ( !move_uploaded_file($this->_filename['tmp_name'], $this->_save_file) )
				{
					$this->_upload_error = 2;
					return false;  //上传失败
				}
			}
		}


		//		if ( !preg_match("/" . $this->_input_type . "/i", 'gijpeg|png|bmp') )  //不是图片时，GIF不要用GD处理
		if ( !preg_match("/" . $this->_input_type . "/i", 'gif|jpeg|png|bmp') )  //不是图片时
		{
			return true;
		}
		else
		{
			if ( $this->_force_gd_gif == false && strtolower($this->_input_type) == 'gif' )
			{
				return true;
			}

			switch ( $this->_input_type )
			{
				case 'gif':
					$src_img = ImageCreateFromGIF($this->_save_file);
					break;

				case 'jpeg':
					$src_img = ImageCreateFromJPEG($this->_save_file);
					break;

				case 'png':
					$src_img = ImageCreateFromPNG($this->_save_file);
					break;

				default:
					$src_img = ImageCreateFromString($this->_save_file);
					break;
			}

			unlink($this->_save_file);

			$src_w = ImageSX($src_img);
			$src_h = ImageSY($src_img);

			if ( $this->_limit_height_width == true && $this->_allow_force == false ) //当限制图片高度和宽度时，同时又不强制图片高和宽时
			{
				if ( $src_w > $this->_max_width || $src_h > $this->_max_height ||  $src_w < $this->_min_width || $src_h < $this->_min_height )
				{
					$this->_upload_error = 3; //返回3表示当图片高度和宽度不符合指定大小
					return false;
				}
			}

			if ( $this->_allow_force == true )  //是否强制
			{
				if ( $this->_force_type == 0 )  //强制所有图片
				{
					$new_w = ( $this->_force_width > 0 ) ? $this->_force_width : $src_w;
					$new_h = ( $this->_force_height > 0 ) ? $this->_force_height : $src_h;
				}
				elseif ( $this->_force_type == 1 )   //强制不符合尺寸大小的
				{
					if ( $src_w > $this->_max_width || $src_h > $this->_max_height )  //图片尺寸太大
					{
						if ( $this->_force_mode == 0 ) //强制成固定大小
						{
							$new_w = $this->_force_width;
							$new_h = $this->_force_height;
						}
						else   //等比强制
						{
							$rate_w = $src_w / $this->_force_width;
							$rate_y = $src_h / $this->_force_height;
							$my_rate = ( $rate_w > $rate_y ) ? $rate_w : $rate_y;

							$new_w = ( $this->_force_width > 0 ) ? ( $src_w / $my_rate ) : $src_w;
							$new_h = ( $this->_force_height > 0 ) ? ( $src_h / $my_rate ) : $src_h;
						}

					}
					else
					{
						$new_w = $src_w;
						$new_h = $src_h;
					}
				}
			}
			else
			{
				$new_w = $src_w;
				$new_h = $src_h;
			}


			if ( $this->_input_type == 'gif' )
			{
				$dst_img = ImageCreate($new_w, $new_h);
				$white = ImageColorAllocate($dst_img, 255, 255, 255);
				@ImageFilledRectangle($dst_img, 0, 0, $new_w, $new_h, $white);
			}
			else
			{
				$dst_img = ImageCreateTrueColor($new_w, $new_h);
			}
			@ImageCopyreSampled($dst_img, $src_img, 0, 0, 0, 0, $new_w, $new_h, ImageSX($src_img), ImageSY($src_img));

			//水印
			if ( $this->_allow_mark == 1 )
			{
				if ( $this->_mark_type == 0 ) //文本水印
				{
					//水印大致的长度
					$mark_len = strlen($this->_mark_words);
					$mark_w = $mark_len * ImageFontWidth($this->_words_size);
					$mark_y = ImageFontHeight($this->_words_size);

					if ( !isset($mark_w) )
					{
						$mark_w = 0;
					}

					if ( !isset($mark_h) )
					{
						$mark_h = 0;
					}

					//水印位置
					if ( $this->_mark_place > 0 )
					{
						switch ( $this->_mark_place )
						{
							case 1:
								$this->_mark_x = 20;
								$this->_mark_y = 20;
								break;
							case 2:
								$this->_mark_x = ($new_w - $mark_w) / 2;
								$this->_mark_y = 20;
								break;
							case 3:
								$this->_mark_x = $new_w - $mark_w - 20;
								$this->_mark_y = 20;
								break;
							case 4:
								$this->_mark_x = 20;
								$this->_mark_y = ($new_h - $mark_h) / 2;
								break;
							case 5:
								$this->_mark_x = ($new_w - $mark_w) / 2;
								$this->_mark_y = ($new_h - $mark_h) / 2;
								break;
							case 6:
								$this->_mark_x = $new_w - $mark_w - 20;
								$this->_mark_y = ($new_h - $mark_h) / 2;
								break;
							case 7:
								$this->_mark_x = 20;
								$this->_mark_y = $new_h - $mark_h - 20;
								break;
							case 8:
								$this->_mark_x = ($new_w - $mark_w) / 2;
								$this->_mark_y = $new_h - $mark_h - 20;
								break;
							case 9:
								$this->_mark_x = $new_w - $mark_w - 20;
								$this->_mark_y = $new_h - $mark_h - 20;
								break;
						}

						$this->_mark_x = ( $this->_mark_x < 0 ) ? 20 : $this->_mark_x;
						$this->_mark_y = ( $this->_mark_y < 0 ) ? 20 : $this->_mark_y;

					}

					if ( @preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->_words_color, $color) )
					{
						$red = hexdec($color[1]);
						$green = hexdec($color[2]);
						$blue = hexdec($color[3]);
					}
					else
					{
						$red = hexdec('00');
						$green = hexdec('00');
						$blue = hexdec('00');
					}
					$this->_words_color = ImageColorAllocateAlpha($dst_img, $red, $green, $blue, $this->_image_rate);

					//加TTF文字，可惜服务器不支持，暂停该功能
					//ImageTTFText($dst_img, $this->_words_size, $this->_words_angle, $this->_mark_x, $this->_mark_y, $this->_words_color, $this->_fontfile, $this->_mark_words);

					//加文字水印的功能改为
					if ( $this->_words_angle == 1 )
					{
						ImageStringUp($dst_img, $this->_words_size, $this->_mark_x, $this->_mark_y, $this->_mark_words, $this->_words_color);
					}
					else
					{
						ImageString($dst_img, $this->_words_size, $this->_mark_x, $this->_mark_y, $this->_mark_words, $this->_words_color);
					}

				}
				else //图片水印
				{
					$wimage_data  =  GetImageSize($this->_mark_image);
					switch($wimage_data[2])
					{
						case  1:
							$wimage = @ImageCreateFromGIF($this->_mark_image);
							break;
						case  2:
							$wimage = @ImageCreateFromJPEG($this->_mark_image);
							break;
						default:
							$wimage = @ImageCreateFromPNG($this->_mark_image);
							break;
					}
					if ( preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->_del_color, $wi_color) )
					{
						$wi_red = hexdec($wi_color[1]);
						$wi_green = hexdec($wi_color[2]);
						$wi_blue = hexdec($wi_color[3]);
					}
					else
					{
						$wi_red = hexdec('FF');
						$wi_green = hexdec('FF');
						$wi_blue = hexdec('FF');
					}

					//水印位置
					if ( $this->_mark_place > 0 )
					{
						switch ( $this->_mark_place )
						{
							case 1:
								$this->_mark_x = 5;
								$this->_mark_y = 5;
								break;
							case 2:
								$this->_mark_x = ($new_w - $this->_image_w) / 2;
								$this->_mark_y = 5;
								break;
							case 3:
								$this->_mark_x = $new_w - $this->_image_w - 5;
								$this->_mark_y = 5;
								break;
							case 4:
								$this->_mark_x = 5;
								$this->_mark_y = ($new_h - $this->_image_h) / 2;
								break;
							case 5:
								$this->_mark_x = ($new_w - $this->_image_w) / 2;
								$this->_mark_y = ($new_h - $this->_image_h) / 2;
								break;
							case 6:
								$this->_mark_x = $new_w - $this->_image_w - 5;
								$this->_mark_y = ($new_h - $this->_image_h) / 2;
								break;
							case 7:
								$this->_mark_x = 5;
								$this->_mark_y = $new_h - $this->_image_h - 5;
								break;
							case 8:
								$this->_mark_x = ($new_w - $this->_image_w) / 2;
								$this->_mark_y = $new_h - $this->_image_h - 5;
								break;
							case 9:
								$this->_mark_x = $new_w - $this->_image_w - 5;
								$this->_mark_y = $new_h - $this->_image_h - 5;
								break;
						}

						$this->_mark_x = ( $this->_mark_x < 0 ) ? 5 : $this->_mark_x;
						$this->_mark_y = ( $this->_mark_y < 0 ) ? 5 : $this->_mark_y;

					}

					$del_bg_color = ImageColorResolve($wimage, $wi_red, $wi_green, $wi_blue);
					ImageColorTransparent($wimage, $del_bg_color);

					ImageAlphaBlending($wimage, false);
					ImageColorTransparent($wimage, $del_bg_color);
					ImageSaveAlpha($wimage,true);

					ImageAlphaBlending($dst_img, true);

					//ImageCopyMerge($dst_img, $wimage, $this->_mark_x, $this->_mark_y, 0, 0, $this->_image_w, $this->_image_h, $this->_image_rate);
					ImageCopy($dst_img, $wimage, $this->_mark_x, $this->_mark_y, 0, 0, $this->_image_w, $this->_image_h);
					@ImageDestroy($wimage);
				}
			}

			switch ( $this->_output_type )
			{
				case 'gif':
					$dst_img = ImageGIF($dst_img, $this->_save_file);
					break;

				case 'jpeg':
					$dst_img = ImageJPEG($dst_img, $this->_save_file, $this->_image_quality);
					break;

				case 'png':
					$dst_img = ImagePNG($dst_img, $this->_save_file);
					break;

				default:
					$dst_img = ImageJPEG($dst_img, $this->_save_file, $this->_image_quality);
					break;
			}

			@ImageDestroy($src_img);
			@ImageDestroy($dst_img);

			return true;  //图片上传成功
		}

	}
}



//检查是不是有文件提交，如果有则返回文件内容，否则返回False
function check_file($file)
{
	$have_file = false;

	if ( isset($file['name']) && $file['name'] != '' )
	{
		$have_file = true;
		$file_path = $file;
	}

	if ( $have_file == false )
	{
		return false;
	}
	else
	{
		return $file_path;
	}
}


//取得文件的扩展名
function get_up_file_exts($myfilename)
{
	$mypos = strrpos($myfilename, '.');
	$exts = substr($myfilename, $mypos + 1, (strlen($myfilename) - $mypos - 1));
	return $exts;
}

//远程上传
function remote_upload($sContent)
{
	global $system_config;
	
	if ( $sContent )
	{
		$my_exts = 'et|fla|wps|csv|ppt|vbrm|pdf|rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov|rar|zip|exe|doc|xls|chm|hlp|swf|gif|jpg|jpeg|bmp|png';
		if ( preg_match_all ("/(http|https|ftp|rtsp|mms):(\/\/|\\\\){1}(([A-Za-z0-9_-])+[.]){1,}([A-Za-z0-9]{1,3})(\S*\/)((\S)+[.]{1}(" . $my_exts . "))/i", $sContent, $out, PREG_PATTERN_ORDER) )
		{
			$date_time = date('Ymd');
			$sFilePath = '/upload/editor/' . $date_time . '/';
			$load_to = UPLOAD . 'editor/' . $date_time . '/';

			if (!is_dir($load_to))
			{
				if ( mkdir($load_to) )
				{
					chmod($load_to, 0777);
				}
			}

			$my_array = array_unique($out[0]);

			foreach ($my_array as $list_val)
			{
				if ( !preg_match("/^(http:\/\/)(" . $system_config['website_domain'] . ")/i", $list_val) )
				{
					$exts = get_up_file_exts($list_val);

					$sNewFileName = str_replace(".", "", str_replace(" ", "", str_replace("\"",  "", microtime()))) . '.' . $exts; //重命名

					$sFileName = $sFilePath . $sNewFileName;
					$to_path = $load_to . $sNewFileName;

					$upload = new upload(array(
					'filename' => $list_val,
					'allow_force' => false,
					'save_file' => $to_path,
					'limit_size' => false,
					'limit_exts' => true,
					'allow_exts' => $my_exts,
					'allow_mark' => 0,
					'limit_height_width' => false
					)
					);

					$my_error = $upload->get_error();

					if ( $my_error == 0 || $my_error == 1 || $my_error == 2 || $my_error == 3 || $my_error == 4 || $my_error == 5 )
					{
						continue;
					}
					else
					{
						$upload_now = $upload->upload_now();
						if ( $upload_now == false )
						{
							continue;
						}
						else
						{
							$sContent = str_replace($list_val, $sFileName, $sContent);
							sleep(0.01);
						}
					}
				}
				else
				{
					continue;
				}
			}
		}

		return $sContent;
	}
	else
	{
		return false;
	}
} //end function remote_upload


/*示例
缩小图片
include_once(LIBS . 'upload.' . $phpEx);

$reduce_pic = new reduce_pic(array(
'filename' => '',  //原图片的文件名，必须提供
'save_file' => '',  //另存为的图片文件名，包括路径，不提供就表示覆盖原图片
'width' => 0,  //缩小后的宽度，为0或不提供时按高度等比缩小
'height' => 0)  //缩小后的高度，为0或不提供时按宽度等比缩小
);

*/

class reduce_pic
{
	var $_error = '';  //错误
	var $_filename = ''; //原图片的文件名，必须提供
	var $_save_file = ''; //另存为的图片文件名，包括路径，不提供就表示覆盖原图片
	var $_width = 0; //缩小的宽度，为0时按高度等比缩小
	var $_height = 0;  //缩小的高度，为0时按宽度等比缩小
	var $_old_width = 0; //原图片宽
	var $_old_height = 0; //原图高宽

	/**
     * 控制参数
     *
     * -------------------------------------------------------------------------
	 * - filename	(array):	输入文件的文件名(也可以直接是文件数据) 
	 * - save_file	(string):	输出文件名，包括路径
	 *
	 * - width	(int):	缩小的宽度
	 * - height	(int):	缩小的高度
     *
     * @param mixed $options  array()  
     *                          
     */
	function reduce_pic( $options = array() )
	{
		if ( isset($options['filename']) )
		{
			$this->_filename =  $options['filename'];

			if ( !file_exists($this->_filename) )
			{
				$this->_error = 'File not exist';
				return false;
			}
		}
		else
		{
			$this->_error = 'No file';
			return false;
		}

		if ( isset($options['save_file']) )
		{
			$this->_save_file =  $options['save_file'];
		}

		if ( $this->_save_file == '' )
		{
			$this->_save_file = $this->_filename;
		}

		if ( isset($options['width']) )
		{
			$this->_width =  $options['width'];
		}

		if ( isset($options['height']) )
		{
			$this->_height =  $options['height'];
		}

		//得到原图片的扩展名
		$file_ext = $this->get_file_exts($this->_filename);

		//得到原图片的宽和高
		switch ( strtolower($file_ext) )
		{
			case 'gif':
				$src_img = ImageCreateFromGIF($this->_filename);
				break;

			case 'jpg':
				$src_img = ImageCreateFromJPEG($this->_filename);
				break;

			case 'jpeg':
				$src_img = ImageCreateFromJPEG($this->_filename);
				break;

			case 'png':
				$src_img = ImageCreateFromPNG($this->_filename);
				break;
		}
		$this->_old_width = ImageSX($src_img);
		$this->_old_height = ImageSY($src_img);

		//当宽都未指定时，按高等比缩放
		if ( $this->_width == 0 )
		{
			$this->_width = $this->_old_width * $this->_height / $this->_old_height;
		}

		//当高都未指定时，按宽等比缩放
		if ( $this->_height == 0 )
		{
			$this->_height = $this->_old_height * $this->_width / $this->_old_width;
		}

		//当高、宽都未指定时
		if ( $this->_width == 0 && $this->_height == 0 )
		{
			$this->_width = 1;
			$this->_height = 1;
		}

		if ( strtolower($file_ext) == 'gif' )
		{
			$dst_img = ImageCreate($this->_width, $this->_height);
			$white = ImageColorAllocate($dst_img, 255, 255, 255);
			@ImageFilledRectangle($dst_img, 0, 0, $this->_width, $this->_height, $white);
		}
		else
		{
			$dst_img = ImageCreateTrueColor($this->_width, $this->_height);
		}
		@ImageCopyreSampled($dst_img, $src_img, 0, 0, 0, 0, $this->_width, $this->_height, ImageSX($src_img), ImageSY($src_img));

		if ( $this->_save_file == $this->_filename )
		{
			unlink($this->_filename);
		}
		else
		{
			if ( file_exists($this->_save_file) )
			{
				$this->_error = 'No filename for save';
				exit;
			}
		}

		switch ( strtolower($file_ext) )
		{
			case 'gif':
				$dst_img = ImageGIF($dst_img, $this->_save_file);
				break;

			case 'jpg':
				$dst_img = ImageJPEG($dst_img, $this->_save_file);
				break;

			case 'jpeg':
				$dst_img = ImageJPEG($dst_img, $this->_save_file);
				break;

			case 'png':
				$dst_img = ImagePNG($dst_img, $this->_save_file);
				break;
		}

		@ImageDestroy($src_img);
		@ImageDestroy($dst_img);
	}

	function get_file_exts($myfilename)
	{
		$mypos = strrpos($myfilename, '.');
		$exts = substr($myfilename, $mypos + 1, (strlen($myfilename) - $mypos - 1));
		return $exts;
	}

	function get_error()
	{
		return $this->_error;
	}  //end function get_error
}

?>