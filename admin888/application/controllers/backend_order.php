<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->model('backend_order_model');
		$this->load->model('products_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{

		$config['base_url'] = base_url('backend_order/index');
		$config['total_rows'] = $this->backend_order_model->get_backend_order_count();
		$config['per_page'] = 28; 
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

        $this->pagination->initialize($config); 
		$data['backend_order_list'] = $this->backend_order_model->get_backend_order($page, $config['per_page']);
		$data['links_pagination'] = $this->pagination->create_links();

		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['type_list'] = $this->products_model->get_type();

		//call script
        $data['menu_id'] ='16';
		$data['content'] = 'backend_order';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'backend_order| '.$this->config->item('sitename'),
								'description' =>  'backend_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);	
	}


	//page search
	public function search()
	{

		$return_data = $this->backend_order_model->get_backend_order_search();
		$data['backend_order_list'] = $return_data['result_backend_order'];
		$data['data_search'] = $return_data['data_search'];
		$data['menus_list'] = $this->initdata_model->get_menu();

        $data['menu_id'] ='16';
		$data['content'] = 'backend_order';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'backend_order| '.$this->config->item('sitename'),
								'description' =>  'backend_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);	

	}

	//page edit
	public function edit($backend_order_id)
	{
		$this->is_logged_in();
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['backend_order_data'] = $this->backend_order_model->get_backend_order_id($backend_order_id);
		$data['type_list'] = $this->products_model->get_type();
        $data['menu_id'] ='1';
		$data['content'] = 'backend_order_edit';
		$data['script_file']= "js/product_add_js";
		$data['header'] = array('title' => 'backend_order| '.$this->config->item('sitename'),
								'description' =>  'backend_order| '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);	

	}

	// update
	public function update($backend_order_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		//save backend_order
		$this->backend_order_model->update_backend_order($backend_order_id);

		if($backend_order_id!=""){
			redirect('backend_order/edit/'.$backend_order_id);
		}
		else {
			redirect('backend_order');
		}

	} 
	
	// insert
	public function add()
	{
		date_default_timezone_set("Asia/Bangkok");
		//save document
		$backend_order_id ="";
		$backend_order_id = $this->backend_order_model->save_backend_order();

		if($document_id !=""){
			redirect('backend_order/edit/'.$backend_order_id);
		}
		else {
			redirect('backend_order');
		}	
	}  

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');		
		}		
	}

}

/* End of file backend_order.php */
/* Location: ./application/controllers/backend_order.php */