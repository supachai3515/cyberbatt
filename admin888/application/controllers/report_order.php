<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti
		$this->load->model('initdata_model');
		$this->load->model('report_model');
		$this->load->library('pagination');
		$this->is_logged_in();

	}

	//page view
	public function index($page=0)
	{
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['selectDB'] = $this->report_model->getOrder($searchTxt);
		$data['get_payment'] = $this->report_model->get_sumpayment($searchTxt);

		//call script
		$data['script_file']= "js/report_js";
    $data['menu_id'] ='31';
		$data['content'] = 'report_order';
		$data['header'] = array('title' => 'report_order | '.$this->config->item('sitename'),
								'description' =>  'report_order | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function report_product(){
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['selectDB'] = $this->report_model->getProduct($searchTxt);
		//call script
		$data['script_file']= "js/report_js";
        $data['menu_id'] = '32';
		$data['content'] = 'report_product';
		$data['header'] = array('title' => 'report_product | '.$this->config->item('sitename'),
								'description' =>  'report_product | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function report_price(){
		$data['menus_list'] = $this->initdata_model->get_menu();$searchTxt = $this->input->post();
		/*Search*/
		$searchTxt = $this->input->post();
		$data['resultpost'] = $searchTxt;
		$data['price_report_data'] = $this->report_model->get_price_report($searchTxt);
		//call script
		$data['script_file']= "js/report_js";
        $data['menu_id'] = '33';
		$data['content'] = 'report_price';
		$data['header'] = array('title' => 'report_price | '.$this->config->item('sitename'),
								'description' =>  'report_price | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'cyberbatt');
		$this->load->view('template/layout', $data);
	}

	public function is_logged_in(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		$chk_admin =  $this->session->userdata('permission');
		if(!isset($is_logged_in) || $is_logged_in != true || $chk_admin !='admin'){
			redirect('login');
		}
	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
