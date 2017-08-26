<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Dashboard extends BaseController {
	public function __construct(){
		parent::__construct();
		//call model inti
    
		$this->load->model('dasboard_model');
    $this->isLoggedIn();
	}

	public function index()
	{
    $data['global'] = $this->global;
    $data['menu_id'] ='1';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access'])
    {
      $data['content'] = 'dashboard';
      //if script file
      $data['script_file'] = 'js/dashboard_js';
  		$data['header'] = array('title' => 'Dashboard | '.$this->config->item('sitename'),
              								'description' =>  'Dashboard | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' =>  'Dashboard');

  		$this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
	}
}
