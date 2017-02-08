<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mysqlexpand {
    

	protected $CI;
	
	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =&get_instance();
	}
	
	
	function fetch_page($sql,$page,$pagenum) {
		if($page==null || $page<=0){
			$page = 1;
		}
		if($pagenum==null || $pagenum<=0){
			$pagenum = 10;
		}
		$pos = stristr($sql,'from');
		$countsql = "select count(*) as count ".$pos;

		$groupuse = false;
		$pos1 = stristr($sql,'group by');
		if($pos1) {
			$groupuse = true;
		}

		$pos2 = stristr($sql,'order by');
		if($pos2) {
			$countsql = str_replace($pos2,'',$countsql);
		}
		$queryCount =  $this->CI->db->query($countsql);
		if($groupuse) {
			$countnum = $queryCount->num_rows();
		} else {
			$rows = $queryCount->row();
			$countnum =$rows->count;
		}
		$countpage = ceil($countnum/$pagenum);

		if($page>$countpage) { $page=$countpage; }
		if($page<1) { $page=1; }

		$limitstart = ($page-1)*$pagenum;

		/* 获取数据结果集 */
		$sql = trim($sql,' ;')." limit $limitstart,$pagenum";
		$result = $this->CI->db->query($sql);
		$array['records'] = $countnum;
		$array['total'] = $countpage;
		$array['rows'] = $result->result_array();
		$array['page'] = $page;
		return $array;
	}
}