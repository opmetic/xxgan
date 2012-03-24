<?php
/**
 * 分页类
 *
 * @package pager
 * @author hyb<hyb@icbuy.net>
 * @version $Id: pager.php,v 1.5 2008/03/26 09:26:39 hyb Exp $
 * @copyright (c) 2008 Icbuy Group
 */

class pager
{
	var $page_num_per_group = 5;  //页码每组页码数
	var $total_item = 0;  //总记录数
	var $per_page_num = 10;  //每页记录数
	var $first_page_num = 1;  //首页页码数
	var $pre_page_num = 0;  //上页页码数
	var $next_page_num = 0;  //下页页码数
	var $last_page_num = 0;  //尾页页码数
	var $pre_group_page_num = 0;  //上一组的显示页码数
	var $next_group_page_num = 0;  //下一组的显示页码数
	var $cur_group_page = array(); //当前组的页面页码数列表
	var $cur_page = 1;  //当前页码数
	var $cur_group = 0; //当前组
	var $total_group = 0; //总组数
	var $page_num = array();  //所有页码
	var $total_page = 0;  //总页数
	var $cur_item_num = 0;  //当前页记录条数

	function pager($total_item = 0, $per_page_num = 10, $page_num_per_group = 3, $cur_page = 1)
	{
		$this->cur_page = (int)$cur_page; //得到当前页码数
		$this->per_page_num = ($per_page_num > 0) ? ceil($per_page_num) : 10; //得到每页记录数
		$this->page_num_per_group = ($page_num_per_group > 0) ? ceil($page_num_per_group) : 3; //得到页码每组页码数

		if ($total_item < 1)
		{
			$this->page_num = false; //即无分页
		}
		else
		{
			$this->total_item = $total_item;

			$this->total_page = ceil($this->total_item / $this->per_page_num); //得到总页数
			$this->last_page_num = $this->total_page; //得到尾页页码数

			if ($this->cur_page < 1)
			{
				$this->cur_page = 1; //得到当前页码数
			}

			if ($this->cur_page > $this->total_page)
			{
				$this->cur_page = $this->total_page; //得到当前页码数
			}

			$this->pre_page_num = ($this->cur_page > 1) ? $this->cur_page - 1 : 1; //得到上页页码数
			$this->next_page_num = ($this->cur_page < $this->total_page) ? $this->cur_page + 1 : $this->total_page; //得到下页页码数

			$this->total_group = ceil($this->total_page / $this->page_num_per_group); //得到总组数
			$this->cur_group = ceil($this->cur_page / $this->page_num_per_group); //得到当前组数

			if ($this->total_group > 1)
			{
				if ($this->cur_group > 1) //当前组不是第一组
				{
					$this->pre_group_page_num = ($this->cur_group - 1) * $this->page_num_per_group;  //得到上一组的显示页码数
				}

				if ($this->cur_group < $this->total_group)  //当前组不是最后一组
				{
					$this->next_group_page_num = ($this->cur_group * $this->page_num_per_group) + 1;  //得到下一组的显示页码数
				}
			}

			$this->cur_group_page[0] = (($this->cur_group - 1) * $this->page_num_per_group) + 1; //当前组第一页
			for ($i = 1; $i < $this->page_num_per_group; $i++)
			{
				if ($this->cur_group_page[0] <= ($this->total_page - $i))
				{
					$this->cur_group_page[$i] = $this->cur_group_page[0] + $i; //当前组其它页
				}
			}

			if ($this->cur_page == $this->total_page)
			{
				$this->cur_item_num = $this->total_item - (($this->total_page -1) * $this->per_page_num);
			}
			else
			{
				$this->cur_item_num = $this->per_page_num;
			}

			$this->page_num = array();
			$this->page_num['total_item'] = $this->total_item;
			$this->page_num['page_num_per_group'] = $this->page_num_per_group;
			$this->page_num['per_page_num'] = $this->per_page_num;
			$this->page_num['first_page_num'] = $this->first_page_num;
			$this->page_num['pre_page_num'] = $this->pre_page_num;
			$this->page_num['next_page_num'] = $this->next_page_num;
			$this->page_num['last_page_num'] = $this->last_page_num;
			$this->page_num['pre_group_page_num'] = $this->pre_group_page_num;
			$this->page_num['next_group_page_num'] = $this->next_group_page_num;
			$this->page_num['cur_group_page'] = $this->cur_group_page;
			$this->page_num['cur_page'] = $this->cur_page;
			$this->page_num['cur_group'] = $this->cur_group;
			$this->page_num['total_group'] = $this->total_group;
			$this->page_num['total_page'] = $this->total_page;
			$this->page_num['cur_item_num'] = $this->cur_item_num;
		}
	}

	/**
	 * 获取各相关页码数
	 *
	 * @return bool 或 array ，如果是false表示无记录，如果是数组，返回值如下：
	 * 		$this->page_num['total_item']--------------------------------总记录条数
			$this->page_num['page_num_per_group']------------------------每组显示的页码数
			$this->page_num['per_page_num']------------------------------每页显示的记录条数
			$this->page_num['first_page_num']----------------------------第一页页码
			$this->page_num['pre_page_num']------------------------------上一页页码
			$this->page_num['next_page_num']-----------------------------下一页页码
			$this->page_num['last_page_num']-----------------------------最后一页码
			$this->page_num['pre_group_page_num']------------------------上一组显示的页码
			$this->page_num['next_group_page_num']-----------------------下一组显示的页码
			$this->page_num['cur_group_page']----------------------------当前组的页码列表，是一个数组
			$this->page_num['cur_page']----------------------------------当前页码
			$this->page_num['cur_group']---------------------------------当前组
			$this->page_num['total_group']-------------------------------总组数
			$this->page_num['total_page']--------------------------------总页数
			$this->page_num['cur_item_num']------------------------------当前页的记录条数
	 */
	function get_page_num()
	{
		return $this->page_num;
	}

	function get_cur_page()
	{
		return $this->cur_page;
	}
}

class pager_str extends pager
{
	//设定
	var $total_item_str = "&nbsp;&nbsp;共%s条 "; //共多少条，如果为空表示不要此项
	var $cur_item_str = "当前页%s条 "; //当前页多少条，如果为空表示不要此项
	var $tj_cur_page_str = "%s/"; //统计段当前页码，如果为空表示不要此项
	var $total_page_str = "%s页 "; //总页数，如果为空表示不要此项

	var $first_page_str = "<a href='%s' class='text_link_class'>首页</a> "; //第一页，如果为空表示不要此项
	var $first_page_str2 = "首页 "; //第一页，没有链接的情况，如果为空表示不要此项
	var $pre_page_str = "<a href='%s' class='text_link_class'>上页</a> "; //上一页，如果为空表示不要此项
	var $pre_page_str2 = "上页 "; //上一页，没有链接的情况，如果为空表示不要此项
	var $next_page_str = " <a href='%s' class='text_link_class'>下页</a> "; //下一页，如果为空表示不要此项
	var $next_page_str2 = " 下页 "; //下一页，没有链接的情况，如果为空表示不要此项
	var $last_page_str = "<a href='%s' class='text_link_class'>尾页</a> "; //最后一页，如果为空表示不要此项
	var $last_page_str2 = "尾页 "; //最后一页，没有链接的情况，如果为空表示不要此项

	var $go_text_str = "<input type='text' name='page' value='%s' size='3' /> "; //跳转框，如果为空表示不要跳转
	var $go_submit_str = "<input type='submit' name='go' value='GO' />&nbsp;&nbsp;"; //跳转按钮

	var $group_split_str = ' ... '; //分页组的分割符，如果为空表示不用显示页数
	var $page_split_str = ' '; //页码之间的分割符
	var $cur_page_str = "<span class='cur_page_class'>%s</span>"; //当前页页码
	var $not_cur_page_str = "<a href='%s' class='num_link_class'>%s</a>"; //非当前页页码

	var $url_start = ''; //网址头
	var $url_end = ''; //网址尾
	
	var $style_table = 'border="0" cellpadding="0" cellspacing="0" style="border:0px;"'; //表格样式
	var $style_td = 'align="left" style="border-bottom:0px; border-top:0px;"'; //单元格样式

	var $page_str = ''; //将要输出的分页内容
    var $cur_page = 1;  //当前页码数    
    var $url_arr = array();

	function pager_str($options = array())
	{
		global $mod, $do;

		foreach ( $options as $k=>$v )
		{   
			$this->$k = $v;
		}
        
		/*
		if ($this->url_start == '')
		{
		$this->url_start = '/' . $mod . '/';
		}

		if (substr($this->url_start, -1) != '/') //在最后加上'/'
		{
		$this->url_start .= '/';
		}

		if ($this->url_end == '')
		{
		$this->url_end = $do . '.html';
		}

		if (substr($this->url_end, 0, 1) == '/') //去掉开头的'/'
		{
		$this->url_end = substr($this->url_end, 0, -1);
		}
		*/

		//$this->url_start = '/' . $mod . '/;
		//$this->url_start = '?';
		/*
        $url_arr = array();
		if (isset($_POST) && sizeof($_POST) && isset($_GET) && sizeof($_GET))
		{
			$url_arr = array_merge($_POST, $_GET);
		}
		else if (isset($_POST) && sizeof($_POST))
		{
			$url_arr = $_POST;
		}
		else if (isset($_GET) && sizeof($_GET))
		{
			$url_arr = $_GET;
		}
        */
        
		if (sizeof($this->url_arr))
		{
			foreach ($this->url_arr as $k => $v)
			{
				if ($k != 'page' && $k != 'go' && $k != 'mod' && $k != 'do')
				{
					if ($k == 'key') {
						$this->url_start .= trim($k) . '/' . replace_str_for_url($v) . '/';
					}
					else {
						$this->url_start .= trim($k) . '/' . $v . '/';
					}
				}
			}
		}

		$this->pager($this->total_item, $this->per_page_num, $this->page_num_per_group, $this->cur_page);

		if ($this->page_num)
		{
			$this->page_str = '<table ' . $this->style_table . '>';
			$this->page_str .= ($this->go_text_str != '') ? '<form id="page_go" name="page_go" method="post" action="' . $this->url_start . $this->url_end . '">' : '';
			$this->page_str .= '<tr><td ' . $this->style_td . '>';

			$this->page_str .= ($this->total_item_str != '') ? sprintf($this->total_item_str, $this->total_item) : '';
			$this->page_str .= ($this->cur_item_str != '') ? sprintf($this->cur_item_str, $this->cur_item_num) : '';
			$this->page_str .= ($this->tj_cur_page_str != '') ? sprintf($this->tj_cur_page_str, $this->cur_page) : '';
			$this->page_str .= ($this->total_page_str != '') ? sprintf($this->total_page_str, $this->total_page) : '';

			if ($this->cur_page == 1)
			{
				$this->page_str .= $this->first_page_str2 . $this->pre_page_str2;
			}
			else
			{
				$this->page_str .= ($this->first_page_str != '') ? sprintf($this->first_page_str, $this->url_start . 'page/' . $this->first_page_num) : '';
				$this->page_str .= ($this->pre_page_str != '') ? sprintf($this->pre_page_str, $this->url_start . 'page/' . $this->pre_page_num) : '';
			}

			if ($this->group_split_str != '')
			{
				if ($this->pre_group_page_num)
				{
					$this->page_str .= ($this->not_cur_page_str != '') ? sprintf($this->not_cur_page_str, $this->url_start . 'page/' . $this->pre_group_page_num, $this->pre_group_page_num) . $this->group_split_str : '';
				}

				foreach ($this->cur_group_page as $k => $v)
				{
					if ($this->cur_page == $v)
					{
						$this->page_str .= ($this->cur_page_str != '') ? sprintf($this->cur_page_str, $v) : '';
					}
					else
					{
						$this->page_str .= ($this->not_cur_page_str != '') ? sprintf($this->not_cur_page_str, $this->url_start . 'page/' . $v, $v) : '';
					}

					$this->page_str .= $this->page_split_str;
				}

				if ($this->next_group_page_num)
				{
					$this->page_str .= ($this->not_cur_page_str != '') ? $this->group_split_str . sprintf($this->not_cur_page_str, $this->url_start . 'page/' . $this->next_group_page_num, $this->next_group_page_num) : '';
				}
			}

			if ($this->cur_page == $this->total_page)
			{
				$this->page_str .= $this->next_page_str2 . $this->last_page_str2;
			}
			else
			{
				$this->page_str .= ($this->next_page_str != '') ? sprintf($this->next_page_str, $this->url_start . 'page/' . $this->next_page_num) : '';
				$this->page_str .= ($this->last_page_str != '') ? sprintf($this->last_page_str, $this->url_start . 'page/' . $this->last_page_num) : '';
			}

			if ($this->go_text_str != '')
			{
				$this->page_str .= sprintf($this->go_text_str, $this->cur_page) . $this->go_submit_str;
			}

			$this->page_str .= '</td></tr>';
			$this->page_str .= ($this->go_text_str != '') ? '</form>' : '';
			$this->page_str .= '</table>';
		}
		else
		{
			$this->page_str = '';
		}
	}

	function get_page_str()
	{
		return $this->page_str;
	}
}

?>
