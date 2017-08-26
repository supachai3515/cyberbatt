<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Report_order extends BaseController {
	public function __construct(){
		parent::__construct();
    
		$this->load->model('report_model');
		$this->load->model('products_model');
    $this->isLoggedIn();

	}

	//page view
	public function index($page=0)
	{

		$data['global'] = $this->global;
    $data['menu_id'] ='10';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

			$searchTxt = $this->input->post();
			$data['resultpost'] = $searchTxt;
			$data['selectDB'] = $this->report_model->getOrder($searchTxt);
			$data['get_payment'] = $this->report_model->get_sumpayment($searchTxt);

      $data['content'] = 'reports/report_order';
      //if script file
      $data['script_file'] = 'js/report_js';
  		$data['header'] = array('title' => 'Report order | '.$this->config->item('sitename'),
              								'description' =>  'Report order | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      //access denied
       $this->loadThis();
    }
	}

	public function report_product()
	{
		$data['global'] = $this->global;
    $data['menu_id'] ='11';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

			$searchTxt = $this->input->post();
			$data['resultpost'] = $searchTxt;
			$data['selectDB'] = $this->report_model->getProduct($searchTxt);
      $data['content'] = 'reports/report_product';
      //if script file
      $data['script_file'] = 'js/report_js';
  		$data['header'] = array('title' => 'Report product | '.$this->config->item('sitename'),
              								'description' =>  'Report product | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      //access denied
       $this->loadThis();
    }
	}

	public function report_price()
	{

		$data['global'] = $this->global;
    $data['menu_id'] ='12';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

			$searchTxt = $this->input->post();
			$data['resultpost'] = $searchTxt;
			$data['price_report_data'] = $this->report_model->get_price_report($searchTxt);
      $data['content'] = 'reports/report_price';
      //if script file
      $data['script_file'] = 'js/report_js';
  		$data['header'] = array('title' => 'Report price | '.$this->config->item('sitename'),
              								'description' =>  'Report price | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      //access denied
       $this->loadThis();
    }

	}

	public function report_purchase_order($inti='')
	{
		$data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

			if($inti ==''){
				//defalut search
				$data_search['all_promotion'] = "1";
				$data_search['is_active'] = "1";
				$data['data_search'] = $data_search;
				$data['products_list']= NULL;
			}
			else {
				$return_data = $this->report_model->get_products_search();
				$data['products_list'] = $return_data['result_products'];
				$data['data_search'] = $return_data['data_search'];
				$data['sql'] = $return_data['sql'];
			}

			$data['brands_list'] = $this->products_model->get_brands();
			$data['type_list'] = $this->products_model->get_type();
			/*Search*/
			$searchTxt = $this->input->post();
			$data['resultpost'] = $searchTxt;
			$data['purchase_order_report_data'] = $this->report_model->get_report_purchase_order($data['products_list'], $searchTxt);
      $data['content'] = 'reports/report_purchase_order';
      //if script file
      $data['script_file'] = 'js/report_js';
  		$data['header'] = array('title' => 'Report price | '.$this->config->item('sitename'),
              								'description' =>  'Report price | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      //access denied
       $this->loadThis();
    }
	}

}

/* End of file prrducts.php */
/* Location: ./application/controllers/prrducts.php */
