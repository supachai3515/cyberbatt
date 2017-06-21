<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('initdata_model');
		$this->load->model('members_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('members/index');
		$config['total_rows'] = $this->members_model->get_members_count();
        /* This Application Must Be Used With BootStrap 3 *  */
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$data['members_list'] = $this->members_model->get_members($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();

		//call script
		$data['content'] = 'report';
		$data['header'] = array('title' => 'report | '.$this->config->item('sitename'),
								'description' =>  'report | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
	}

	//page search
	public function search()
	{

		$return_data = $this->members_model->get_members_search();
		$data['members_list'] = $return_data['result_members'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

		$data['content'] = 'report';
		$data['header'] = array('title' => 'report | '.$this->config->item('sitename'),
								'description' =>  'report | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');

	}

	//page edit


	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
