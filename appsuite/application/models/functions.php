<?php
/**
 * 基本功能函数
 *
 * @package includes
 * @author hyb<hyb@icbuy.net>
 * @version $Id: basics.inc.php,v 1.38 2008/08/13 03:03:03 hyb Exp $
 * @copyright (c) 2008 Icbuy Group
 */

/**
 * 日志
 *
 * @param string $log_type，指对数据表操作的方式，如：增加、查看、修改、导出、删除、登录、退出、审核通过、审核不通过、激活、失效等
 * @param string $data_table，指操作的数据表名，如：TB_MEMBER
 * @param string $data_id，指操作的数据ID，如：1表示ID为１的记录；又如：1-100表示ID为1至100的记录；又如：1,2,4表示１，２，４三条记录
 * @param string $log_info，指具体操作细节说明，如：删除用户名为XXXX的用户
 *
 */
function add_log($log_type, $data_table, $data_id, $log_info)
{
	global $db, $admin_data, $user_data, $user_ip, $mod, $do;

	//是否是虚拟用户操作
	$log_info .= (isset($admin_data['username']) && isset($user_data['username'])) ? '（' . $admin_data['username'] . '[' . $admin_data['real_name'] . ']虚拟成' . $user_data['username'] . '[' . $user_data['real_name'] . ']）' : '';

	$i_arr = array(
	'username' => ($user_data) ? $user_data['username'] : (($admin_data) ? $admin_data['username'] : ''),
	'real_name' => ($user_data) ? $user_data['real_name'] : (($admin_data) ? $admin_data['real_name'] : ''),
	'log_ip' => $user_ip,
	'log_type' => $log_type,
	'log_time' => date("Y-m-d H:i:s"),
	'data_table' => $data_table,
	'data_id' => $data_id,
	'mod_name' => $mod,
	'do_name' => $do,
	'log_info' => $log_info,
	'admin_id' => (isset($admin_data['user_id'])) ? $admin_data['user_id'] : 0,
	'user_id' => (isset($user_data['user_id'])) ? $user_data['user_id'] : 0
	);

	//插入日志表
	$db->insert(TB_LOG, $i_arr);
}

/**
* set_var
*
* Set variable, used by {@link request_var the request_var function}
*
* @private
*/
function set_var(&$result, $var, $type, $multibyte = false)
{
	settype($var, $type);
	$result = $var;

	if ($type == 'string')
	{
		$result = trim(htmlspecialchars(str_replace(array("\r\n", "\r"), array("\n", "\n"), $result)));
		if (defined('STRIP')) 
		{
			$result = (STRIP) ? stripslashes($result) : $result;
		}	

		// Check for possible multibyte characters to save a preg_replace call if nothing is in there...
		if ($multibyte && strpos($result, '&amp;#') !== false)
		{
			$result = preg_replace('#&amp;(\#[0-9]+;)#', '&\1', $result);
		}
	}
}


function set_request()
{
	global $_GET;
	foreach ($_GET as $k => $v)
	{
		$_REQUEST[$k] = urldecode($v);
	}
} //end function set_request

/**
* request_var
*
* Used to get passed variable
* The request_var function determines the type to set from the second parameter (which
* determines the default value too). If you need to get a scalar variable type, you need
* to tell this the request_var function explicitly. Examples:
* 
* 	// Use request var and define a default variable (use the correct type)
* $start = request_var('start', 0);
* $submit = (isset($_POST['submit'])) ? true : false;
* 	// $start is an int, the following use of request_var therefore is not allowed
* $start = request_var('start', '0');
* 
* 	// Getting an array, keys are integers, value defaults to 0 
* $mark_array = request_var('mark', array(0));
* 
* 	// Getting an array, keys are strings, value defaults to 0 
* $action_ary = request_var('action', array('' => 0));
* 
*/
function request_var($var_name, $default, $multibyte = false)
{
	set_request();

	if (!isset($_REQUEST[$var_name]) || (is_array($_REQUEST[$var_name]) && !is_array($default))
	|| (is_array($default) && !is_array($_REQUEST[$var_name])))
	{
		return (is_array($default)) ? array() : $default;
	}

	$var = $_REQUEST[$var_name];
	if (!is_array($default))
	{
		$type = gettype($default);
	}
	else
	{
		list($key_type, $type) = each($default);
		$type = gettype($type);
		$key_type = gettype($key_type);
	}

	if (is_array($var))
	{
		$_var = $var;
		$var = array();

		foreach ($_var as $k => $v)
		{
			if (is_array($v))
			{
				foreach ($v as $_k => $_v)
				{
					set_var($k, $k, $key_type);
					set_var($_k, $_k, $key_type);
					set_var($var[$k][$_k], $_v, $type, $multibyte);
				}
			}
			else
			{
				set_var($k, $k, $key_type);
				set_var($var[$k], $v, $type, $multibyte);
			}
		}
	}
	else
	{
		set_var($var, $var, $type, $multibyte);
	}

	return $var;
}

if (!function_exists('array_combine'))
{
	/**
	* A wrapper for the PHP5 function array_combine()
	* @param array $keys contains keys for the resulting array
	* @param array $values contains values for the resulting array
	*
	* @return Returns an array by using the values from the keys array as keys and the
	* 	values from the values array as the corresponding values. Returns false if the
	* 	number of elements for each array isn't equal or if the arrays are empty.
	*/
	function array_combine($keys, $values)
	{
		$keys = array_values($keys);
		$values = array_values($values);

		$n = sizeof($keys);
		$m = sizeof($values);
		if (!$n || !$m || ($n != $m))
		{
			return false;
		}

		$combined = array();
		for ($i = 0; $i < $n; $i++)
		{
			$combined[$keys[$i]] = $values[$i];
		}
		return $combined;
	}
}

if (!function_exists('str_split'))
{
	/**
	* A wrapper for the PHP5 function str_split()
	* @param array $string contains the string to be converted
	* @param array $split_length contains the length of each chunk
	*
	* @return  Converts a string to an array. If the optional split_length parameter is specified,
	*  	the returned array will be broken down into chunks with each being split_length in length,
	*  	otherwise each chunk will be one character in length. FALSE is returned if split_length is
	*  	less than 1. If the split_length length exceeds the length of string, the entire string is
	*  	returned as the first (and only) array element. 
	*/
	function str_split($string, $split_length = 1)
	{
		if ($split_length < 1)
		{
			return false;
		}
		else if ($split_length >= strlen($string))
		{
			return array($string);
		}
		else
		{
			preg_match_all('#.{1,' . $split_length . '}#s', $string, $matches);
			return $matches[0];
		}
	}
}

if (!function_exists('stripos'))
{
	/**
	* A wrapper for the PHP5 function stripos
	* Find position of first occurrence of a case-insensitive string
	*
	* @param string $haystack is the string to search in
	* @param string needle is the string to search for
	*
	* @return Returns the numeric position of the first occurrence of needle in the haystack  string. Unlike strpos(), stripos() is case-insensitive.
	* Note that the needle may be a string of one or more characters.
	* If needle is not found, stripos() will return boolean FALSE. 
	*/
	function stripos($haystack, $needle)
	{
		if (preg_match('#' . preg_quote($needle, '#') . '#i', $haystack, $m))
		{
			return strpos($haystack, $m[0]);
		}

		return false;
	}
}


// esacape invalid xml charaters
function escapeForXML ($input)
{
	$patterns = array(
	"/\s+/",
	"/[\x-\x8\xb-\xc\xe-\x1f]/", //escape invalid Unicode in XML
	"/<.*?>/"  //remove html tag
	);
	$replace = array(
	" ",
	" ",
	""
	);
	$output .= preg_replace($patterns, $replace, $input);
	return trim(htmlspecialchars($output));
}

// escape for URL
function escapeForURL($url)
{
	//$output = html_entity_decode ($input);
	//$output = htmlentities ($output);
	return str_replace("&", "&amp;", $url);
}


/**
 * URL 转向
 *
 */
function redirect($url)
{
	global $db, $system_config;

	header('Location: ' . $url);
	exit;
}

function check_username($username)
{
	global $system_config;
	if ( !preg_match('/^[a-zA-Z0-9]{' . $system_config['min_username_length'] . ',' . $system_config['max_username_length'] . '}$/i', $username) )
	{
		return false;
	}

	return true;
}  //end function check_username


function check_password($password)
{
	global $system_config;
	if ( !preg_match('/^[a-zA-Z0-9]{' . $system_config['min_password_length'] . ',' . $system_config['max_password_length'] . '}$/i', $password) )
	{
		return false;
	}

	return true;
}  //end function check_password

function check_email($email)
{
	if ( !preg_match('#^[a-z0-9\.\-_\+]+?@(.*?\.)*?[a-z0-9\-_]+?\.[a-z]{2,4}$#i', $email) )
	{
		return false;
	}

	return true;
}  //end function check_email

/**
 * 输出信息并做URL转向
 * @param string   方式，有两方式，一种是'text'文本方式，一段时间后自动转向；另一种是'alert'用JS提示方式提示后再转向
 * @param string   提示信息的内容
 * @param string   要转向的URL网址（如果采用的是'alert'方式，这里的值还可以是-1,表示返回前页）
 * @param string   編碼
 * @param int   时间，只有采用'text'文本方式时，这个值才有效，指多少秒后自动转向网址，缺省是10秒
 */
function message_and_redirect($type, $message, $url, $char = 'utf-8', $time = 10)
{
	global $db;
	$str = '';

	if ( $type == 'text' )
	{
		$str .= '<meta http-equiv="Content-Type" content="text/html; charset=' . $char . '"><meta http-equiv="refresh" content="' . $time . ';url=\'' . $url . '\'">';
		$str .= "\n" . $message;
	}
	elseif ( $type == 'alert' )
	{
		$str .= "<meta http-equiv='Content-Type' content='text/html; charset=" . $char . "'><script language='javascript' type='text/JavaScript'>\n";
		$str .= "\talert('" . $message . "');\n";
		if ( $url == -1 || $url == -2 || $url == -3 || $url == -4 || $url == -5 )
		{
			$str .= "\twindow.history.go(" . $url . ");\n";
		}
		else
		{
			$str .= "\tdocument.writeln('<meta http-equiv=\"refresh\" content=\"0;url=\\'" . $url . "\\'\">');\n";
		}

		$str .= '</script>';
	}

	return $str;
}

function randKey($key_length = 5)
{
	#$possible_charactors = strtoupper("abcdefghijklmnopqrstuvwxyz");
	$possible_charactors = strtoupper("1234567890abcdefghijklmnopqrstuvwxyz");
	$string_key = '';
	while(strlen($string_key) < $key_length)
	{
		$rand_offset = rand() % (strlen($possible_charactors));
		$string_key .= substr($possible_charactors, $rand_offset, 1);
	}
	return $string_key;

} // function randKey


/**
 * Enter 清除HTML语言
 *
 * @param str $content 要清除的文字内容
 * @param boolen $br　是否要清除换行
 */
function clear_html($content, $br = false)
{
	$content = ($br) ? $content : str_replace('<BR>', ';;br;;', str_replace('<BR />', ';;br;;', str_replace('<br />', ';;br;;', str_replace('<br>', ';;br;;', $content))));
	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
	"'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
	"'([\r\n])[\s]+'",                 // Strip out white space
	"'&(quot|#34);'i",                 // Replace html entities
	"'&(amp|#38);'i",
	"'&(lt|#60);'i",
	"'&(gt|#62);'i",
	"'&(nbsp|#160);'i",
	"'&(iexcl|#161);'i",
	"'&(cent|#162);'i",
	"'&(pound|#163);'i",
	"'&(copy|#169);'i",
	"'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
	"",
	"\\1",
	"\"",
	"&",
	"<",
	">",
	" ",
	chr(161),
	chr(162),
	chr(163),
	chr(169),
	"chr(\\1)");

	$content = preg_replace ($search, $replace, $content);
	$content = str_replace(';;br;;', '<BR />', $content);

	return $content;
}  //end function clear_html

function u2utf82gb($c){
	$str="";
	if ($c < 0x80) {
		$str.=chr($c);
	} else if ($c < 0x800) {
		$str.=chr(0xC0 | $c>>6);
		$str.=chr(0x80 | $c & 0x3F);
	} else if ($c < 0x10000) {
		$str.=chr(0xE0 | $c>>12);
		$str.=chr(0x80 | $c>>6 & 0x3F);
		$str.=chr(0x80 | $c & 0x3F);
	} else if ($c < 0x200000) {
		$str.=chr(0xF0 | $c>>18);
		$str.=chr(0x80 | $c>>12 & 0x3F);
		$str.=chr(0x80 | $c>>6 & 0x3F);
		$str.=chr(0x80 | $c & 0x3F);
	}
	return iconv('UTF-8', 'GBK//IGNORE', $str);
}

function uft2gb($str)
{
	$str = preg_replace("|;;([0-9]{1,5});;|", "\".u2utf82gb(\\1).\"", $str);
	$str = "\$str=\"$str\";";

	eval($str);
	return $str;
}  //end function uft2gb

function my_sub_str($string, $length = 0, $etc = '...')
{
	$charset = "utf-8";

	if ($length == 0)
	{
		return $string;
	}

	$str_length = function_exists("mb_strlen") ? mb_strlen($string, $charset) : strlen($string);

	if ($str_length > $length) {
		$length -= strlen($etc);

		//$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));

		$tmp = function_exists('mb_substr') ? mb_substr($string, 0, $length, $charset) : cut_str($string, $length);

		return $tmp . $etc;
	} else {
		return $string;
	}
}

function cut_str($str, $len)
{
	$new_str = '';
	$wordLen = 0;
	while ($wordLen < $len) {
		$temp_str = substr($str, 0, 1);

		if (ord($temp_str) > 127) {   //   中文
			$new_str .= substr($str, 0, 3);
			$str = substr($str, 3);
		} else {   //   E文
			$new_str .= substr($str, 0, 1);
			$str = substr($str, 1);
		}

		$wordLen++;
	}
	return $new_str;
}

//去掉HTML标记后，高亮显示搜索内容
function get_search_content($str, $key, $len = 0, $etc = '...', $clear_html = false)
{
	if (!$key) {
		return $str;
	}

	if (!is_array($key)) {
		$key = array($key);
	}

	if ($clear_html) {
		$str_tmp = clear_html($str);
	}
	else {
		$str_tmp = $str;
	}

	$patterns = array ('/\//i', '/\*/i', '/\?/i');
	$replace = array ('\\/', '\\*', '\\?');
	foreach ($key as $k => $v) {
		$key[$k] = @preg_replace($patterns, $replace, $v);
	}

	if (!(isset($key[0]) && $key[0] != '' && $str_tmp))
	{
		return $str;
	}

	$out_str = ($len > 0) ? my_sub_str($str_tmp, $len, $etc) : $str_tmp;

	foreach ($key as $k => $v) {
		@preg_match_all('/' . $v . '/i', $out_str, $out_array);

		$out_key = array_unique($out_array[0]);
		if ( !is_array($out_key) )
		{
			$out_key = array_unique($out_array);
		}

		if ( is_array($out_key) )
		{
			foreach ( $out_key as $m => $n )
			{
				if (!@preg_match('/' . $n . '/i', '<span class="q_s_t_y"></span>')) {
					$light_key = '<span class="q_s_t_y">' . $n . '</span>';
					$out_str = str_replace($n, $light_key, $out_str);
				}
			}
		}
	}

	return $out_str;
}  //end function get_search_content

function get_sid($nSize = 24)
{
	$sessionID = '';
	mt_srand((double)microtime() * 1000000);
	for ($i=1; $i <= $nSize; $i++)
	{
		$nRandom = mt_rand(1,30);
		if ($nRandom <= 10)
		{
			$sessionID .= chr(mt_rand(65,90));
		} else {
			$sessionID .= chr(mt_rand(97,122));
		}
	}
	return $sessionID;
}


function str_is_int($str)
{
	if ( $str == '0' )
	{
		return true;
	}

	if ( $str != 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * 处理JS日历传入的日期，转换为PHP可以识别的格式。
 * 以及适当纠正输入错误。
 *
 * @param string $start_time
 * @param string $end_time
 * @return array (开始时间，结束时间)
 */
function format_time($start_time, $end_time)
{
	if ($start_time == '' && $end_time == '')
	{
		return array('start_time'=>0,'end_time'=>0);
	}
	if ($start_time != '') {
		$s = explode('-', $start_time);
		$start_time = @mktime(0, 0, 0, $s[1], $s[2], $s[0]);
	}
	else
	{
		$start_time = time();
	}

	if ($end_time != '') {
		$s = explode('-', $end_time);
		$end_time = @mktime(23,59,59, $s[1], $s[2], $s[0]);
	}
	else
	{
		$end_time = time();
	}

	if ($start_time > $end_time)
	{
		$start_time_temp = $start_time;
		$start_time = $end_time;
		$end_time = $start_time_temp;
	}

	return array('start_time' => $start_time, 'end_time' => $end_time);
}

/**
 * 根据一个时间，得出这个时间当天的起始时间
 * 起是从0.00分算起，始是23.59.59算起
 *
 * @param int $time ,string $method	//method用以标识返回天数(d)、还是月数(m)，还是年数(y)
 * @return array(start_time,end_time)
 */
function make_today_time($time, $method = 'd')
{
	if (!$time || date('y-m-d',$time) == '70-01-01')
	{
		$time = time();
	}

	$time_day_begin = '';
	$time_day_end = '';

	if ($method == 'd')
	{
		$time_day_begin = mktime(0,0,0,date('m', $time),date('d', $time), date('y'));
		$time_day_end = mktime(23,59,59,date('m', $time),date('d', $time), date('y'));
	}
	else if ($method == 'm')
	{
		$time_day_begin = mktime(0,0,0,date('m', $time),1, date('y'));	//每个月的一号
		//找找这个月有几天
		$days = date('t', strtotime($time));

		$time_day_end = mktime(23,59,59,date('m', $time),$days, date('y'));
	}
	else if ($method == 'y')
	{
		$time_day_begin = mktime(0,0,0,1,1, date('y'));	//每个月的一号
		//找找这个月有几天
		$days = date('t', strtotime($time));

		$time_day_end = mktime(23,59,59,12,31, date('y'));
	}
	else
	{
		$time_day_begin = mktime(0,0,0,date('m', $time),date('d', $time), date('y'));
		$time_day_end = mktime(23,59,59,date('m', $time),date('d', $time), date('y'));
	}
	return array('start_time' => $time_day_begin, 'end_time'=>$time_day_end);
}

/************** 导出EXCEL　开始***************/
/**
	 * 写入开始
	 *
	 * @param firstname and lastname of author, <author@example.org>
	 * @return void 
	 */
function xlsBOF()
{
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
}

/**
	 * 写入结束
	 *
	 * @param firstname and lastname of author, <author@example.org>
	 * @return void 
	 */
function xlsEOF()
{
	echo pack("ss", 0x0A, 0x00);
	return;
}

/**
	 * 写入数值
	 *
	 * @param firstname and lastname of author, <author@example.org>
	 * @return void 
	 */
function xlsWriteNumber($Row, $Col, $Value)
{
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
}

/**
	 * 写入文本
	 *
	 * @param firstname and lastname of author, <author@example.org>
	 * @return void 
	 */
function xlsWriteLabel($Row, $Col, $Value )
{
	$Value = mb_convert_encoding($Value, "gb2312", "utf-8");

	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
}
/************** 导出EXCEL 结束 ***************/


/**
 * 全角转半角
 *
 * @param unknown_type $str
 * @param unknown_type $args2
 * @return unknown
 */
function SBC_DBC($str,$args2 = 1) { //半角和全角转换函数，第二个参数如果是0,则是半角到全角；如果是1，则是全角到半角
	$DBC = Array(
	'０' , '１' , '２' , '３' , '４' ,
	'５' , '６' , '７' , '８' , '９' ,
	'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,
	'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' ,
	'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,
	'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' ,
	'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,
	'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' ,
	'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,
	'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' ,
	'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,
	'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' ,
	'ｙ' , 'ｚ' , '－' , '　'  , '：' ,
	'．' , '，' , '／' , '％' , '＃' ,
	'！' , '＠' , '＆' , '（' , '）' ,
	'＜' , '＞' , '＂' , '＇' , '？' ,
	'［' , '］' , '｛' , '｝' , '＼' ,
	'｜' , '＋' , '＝' , '＿' , '＾' ,
	'￥' , '￣' , '｀'
	);
	$SBC = Array( //半角
	'0', '1', '2', '3', '4',
	'5', '6', '7', '8', '9',
	'A', 'B', 'C', 'D', 'E',
	'F', 'G', 'H', 'I', 'J',
	'K', 'L', 'M', 'N', 'O',
	'P', 'Q', 'R', 'S', 'T',
	'U', 'V', 'W', 'X', 'Y',
	'Z', 'a', 'b', 'c', 'd',
	'e', 'f', 'g', 'h', 'i',
	'j', 'k', 'l', 'm', 'n',
	'o', 'p', 'q', 'r', 's',
	't', 'u', 'v', 'w', 'x',
	'y', 'z', '-', ' ', ':',
	'.', ',', '/', '%', '#',
	'!', '@', '&', '(', ')',
	'<', '>', '"', '\'','?',
	'[', ']', '{', '}', '\\',
	'|', '+', '=', '_', '^',
	'$', '~', '`'
	);
	if($args2==0)
	return str_replace($SBC,$DBC,$str);  //半角到全角
	if($args2==1)
	return str_replace($DBC,$SBC,$str);  //全角到半角
	else
	return false;
}


/**
 * 字符处理，处理后的字符可以用于网址
 *
 * @param string $str
 * @return string
 */
function replace_str_for_url($str) {
	$DBC = Array(
	'＃', '／', '％', '″',
	);

	$SBC = Array( //半角
	'#', '/', '%', '"',
	);

	return str_replace($SBC, $DBC, $str);  //半角到全角
}

function message_box($msg_text, $msg_type, $url = '') 
{
    global $smarty;
    $smarty->assign('msg_type', $msg_type);
    $smarty->assign('msg_text', $msg_text);
    if ($url != '') 
    {
        $smarty->assign('back_url', $url);
    }
    if ($msg_type == XJT)
    {
    	$smarty->display('xjt/xjt_msg.tpl');
    }
    else if($msg_type == XJT_ADMIN) 
    {
    	$smarty->display('xjt_admin/xjt_msg.tpl');
    }
    else if($msg_type == MANAGE)
    {
    	$smarty->display('system_msg.tpl');
    }
    else 
    {
    	$smarty->display('msg.tpl');
    }
    exit;
}
/**
 * 跳转函数
 *
 * 用法: $a_href_ary = array('/product/manage/'=>'管理产品', '/user/manage/'=>'管理用户');
 * 		 go_to($a_href_ary, $_POST);
 *
 * @param array $a_href_ary, $_POST, $total
 * 说明：$_POST参数 用以返回重填时，保留提交前表单各项中的值，可以为空。total为需返回链接（如：返回上一页）的数组索引值，约定为0。
 * @return string|false
 */
function go_to($a_href_ary, $post_ary = array() , $total = 0) 
{
    if (sizeof($a_href_ary)) 
    {
        $link = '';
        foreach($a_href_ary as $url => $text) 
        {
            //生成隐藏域
            if (sizeof($post_ary) > 0) 
            {
                if ($total == 0) 
                {
                    unset($post_ary['submit']);
                    $link.= "<form name='goback" . $total . "' id='goback" . $total . "' method='POST' action='" . $url . "'>";
                    $link.= build_hidden_fields($post_ary);
                    $link.= "<a href='#' onClick='goback" . $total . ".submit()'>" . $text . '</a>';
                    $link.= '</form>';
                }
            }
            else
            {
                $link.= '<span style="line-height:2">&laquo; <a href="' . $url . '">' . $text . '</a></span><br />';
            }
            $total++;
        }
        return $link;
    }
    return false;
}

/**
 * build_hidden_fields的私有方法
 *
 */
function _build_hidden_fields($key, $value, $specialchar, $stripslashes) 
{
    $hidden_fields = '';
    if (!is_array($value)) 
    {
        $value = ($stripslashes) ? stripslashes($value) : $value;
        $value = ($specialchar) ? htmlspecialchars($value, ENT_COMPAT, 'UTF-8') : $value;
        $hidden_fields.= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
    }
    else
    {
        foreach($value as $_key => $_value) 
        {
            $_key = ($stripslashes) ? stripslashes($_key) : $_key;
            $_key = ($specialchar) ? htmlspecialchars($_key, ENT_COMPAT, 'UTF-8') : $_key;
            $hidden_fields.= _build_hidden_fields($key . '[' . $_key . ']', $_value, $specialchar, $stripslashes);
        }
    }
    return $hidden_fields;
}
/**
 * 建造隐藏域
 *
 * $s_hidden_fields = build_hidden_fields(array(
 *		'user_id'	=> $userdata->user_id,
 *		'confirm_key' => $confirm_key)
 *	);
 *
 * @param array $field_ary
 * @param bool $specialchar
 * @param bool $stripslashes
 *
 * @return string
 */
function build_hidden_fields($field_ary, $specialchar = false, $stripslashes = false) 
{
    $s_hidden_fields = '';
    foreach($field_ary as $name => $vars) 
    {
        $name = ($stripslashes) ? stripslashes($name) : $name;
        $name = ($specialchar) ? htmlspecialchars($name, ENT_COMPAT, 'UTF-8') : $name;
        $s_hidden_fields.= _build_hidden_fields($name, $vars, $specialchar, $stripslashes);
    }
    return $s_hidden_fields;
}


/**
 * 递归,得到分类的缩进表示方式
 */
function operatorSortData($arrparam, &$sortTmp, $parentId = HELP_COMMON)
{
	//将数据转化有　array(id=>data)  的形式
	$arrTmp = array();
	foreach ($arrparam as $sort) {
		$arrTmp[$sort['sort_id']]  = $sort;
	}
	$sortTmp = $arrTmp;
	$result = array();
	//递归，处理数组
	recursion($result, $arrTmp, 0, $parentId);
	
	return ($result);
}

//递归，处理数组
function recursion(&$result, $arrTmp, $step = 0, $parentId = 0)
{
	$flag = false;//是否存在子分类的标志

	//还有未处理的数据
	foreach ($arrTmp as $key => $cell) {
		if ($cell['parent_id'] == $parentId) {
			$flag = true;
			$cell['sort_name'] = getLevelChar($step) . $cell['sort_name'];
			$cell['disable'] = 0;
			$result[$cell['sort_id']] = $cell;
			unset($arrTmp[$key]);
			if (recursion($result, $arrTmp, $step + 1, $key)) { //调用自己 
				$result[$cell['sort_id']]['disable'] = 1;
			}
		}
	}
	return $flag;
}

function getLevelChar($count)
{
	$str = '';
	for ($i=0; $i<$count; $i++) {
		$str .= '|--';
	}
	return $str;
}
?>
