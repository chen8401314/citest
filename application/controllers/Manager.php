<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('manager/manager1');
	}
	public function managerList()
	{
		/* $this->load->library('someclass');
		$this->someclass->some_method(); */
		 $this->load->database();
		 $this->load->library('mysqlexpand');
		$page =  $this->input->post('page');
		$rowNum =  $this->input->post('rowNum');
	      $result = $this->mysqlexpand->fetch_page("select username,nickname,password from manager",$page,$rowNum); 
	   echo json_encode($result);
		/* $this->load->database();
		 $query = $this->db->query("select username,nickname,password from manager");
		foreach ($query->result() as $row)
		{
			echo $row->username;
			echo $row->nickname;
			echo $row->password;
		} */
	}
}
