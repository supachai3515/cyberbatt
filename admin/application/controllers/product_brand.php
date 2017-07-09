<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Product_brand extends BaseController {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('initdata_model');
		$this->load->model('product_brand_model');
    $this->isLoggedIn();
  }

  function index($page=0)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {

      $searchText = $this->input->post('searchText');
      $data['searchText'] = $searchText;
      $count = $this->product_brand_model->get_product_brand_count($searchText);
      $data['links_pagination'] = $this->pagination_compress( "product_brand/index", $count, $this->config->item('pre_page') );
  	  $data['product_brand_list'] = $this->product_brand_model->get_product_brand($searchText, $page, $this->config->item('pre_page'));


      $data['content'] = 'product_brand/product_brand_view';
      //if script file
      //$data['script_file'] = 'js/product_brand_js';
  		$data['header'] = array('title' => 'Product Brand | '.$this->config->item('sitename'),
              								'description' =>  'Product Brand | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		$this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }

  function add()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
        $data['content'] = 'product_brand/product_brand_add_view';
        //if script file
        //$data['script_file'] = 'js/product_brand_js';
  		  $data['header'] = array('title' => 'Add Product Brand | '.$this->config->item('sitename'),
              								'description' =>  'Add Product Brand | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		  $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }

  function view($id=NULL)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
    $data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_view'])
    {
        if($id == null)
        {
            redirect('product_brand');
        }

        $data['product_brand_data'] = $this->product_brand_model->get_product_brand_id($id);

        if(count($data['product_brand_data'])==0){
            redirect('error');
        }

        $data['content'] = 'product_brand/product_brand_info_view';
        //if script file
        //$data['script_file'] = 'js/product_brand_js';
        $data['header'] = array('title' => 'View Product Brand | '.$this->config->item('sitename'),
                              'description' =>  'View Product Brand | '.$this->config->item('tagline'),
                              'author' => $this->config->item('author'),
                              'keyword' => 'Product Brand');
        $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }


  function add_save()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
          $this->form_validation->set_rules('description','description','trim|xss_clean|max_length[128]');
          $this->form_validation->set_rules('is_active','ใช้งาน','');

          if($this->form_validation->run() == FALSE)
          {
              $this->add();
          }
          else
          {
              $name = $this->input->post('name');
              $description = $this->input->post('description');
              $is_active = $this->input->post('is_active');

              $product_brand_info = array('name'=>$name, 'description'=>$description, 'is_active'=>$is_active,
                                      'create_by'=>$this->vendorId, 'create_date'=>date('Y-m-d H:i:s'),
                                      'modified_by'=>$this->vendorId, 'modified_date'=>date('Y-m-d H:i:s'));

              $result = $this->product_brand_model->save_product_brand($product_brand_info);

              if($result > 0)
              {
                  $this->session->set_flashdata('success', 'Add Product Brand created successfully');
              }
              else
              {
                  $this->session->set_flashdata('error', 'User creation failed');
              }
              redirect('product_brand/add');
          }
      }
      else {
           $this->loadThis();
      }
  }

  function edit($id=NULL)
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_edit'])
    {
        if($id == null)
        {
            redirect('product_brand');
        }

        $data['product_brand_data'] = $this->product_brand_model->get_product_brand_id($id);
        if(count($data['product_brand_data'])==0){
            redirect('error');
        }

        $data['content'] = 'product_brand/product_brand_edit_view';
        //if script file
        //$data['script_file'] = 'js/product_brand_js';
  		  $data['header'] = array('title' => 'Add Product Brand | '.$this->config->item('sitename'),
              								'description' =>  'Add Product Brand | '.$this->config->item('tagline'),
              								'author' => $this->config->item('author'),
              								'keyword' => 'Product Brand');
  		  $this->load->view('template/layout_main', $data);
    }
    else {
      // access denied
       $this->loadThis();
    }
  }


  function edit_save()
  {
    $data['global'] = $this->global;
    $data['menu_id'] ='13';
		$data['menu_list'] = $this->initdata_model->get_menu($data['global']['menu_group_id']);
    $data['access_menu'] = $this->isAccessMenu($data['menu_list'],$data['menu_id']);
    if($data['access_menu']['is_access']&&$data['access_menu']['is_add'])
    {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('name','Name','trim|required|max_length[128]|xss_clean');
          $this->form_validation->set_rules('description','description','trim|xss_clean|max_length[128]');
          $this->form_validation->set_rules('is_active','ใช้งาน','');

          if($this->form_validation->run() == FALSE)
          {
              $this->add();
          }
          else
          {
              $name = $this->input->post('name');
              $description = $this->input->post('description');
              $is_active = $this->input->post('is_active');
              $product_brand_id = $this->input->post('product_brand_id');

              $product_brand_info = array('name'=>$name, 'description'=>$description, 'is_active'=>$is_active,
                                      'product_brand_id'=>$product_brand_id,
                                      'modified_by'=>$this->vendorId,
                                      'modified_date'=>date('Y-m-d H:i:s'));

              $result = $this->product_brand_model->update_product_brand($product_brand_info,$product_brand_id);

              if($result > 0)
              {
                  $this->session->set_flashdata('success', 'Edit Product Brand Update successfully');
              }
              else
              {
                  $this->session->set_flashdata('error', 'User creation failed');
              }
              redirect('product_brand/edit/'.$product_brand_id);
          }
      }
      else {
           $this->loadThis();
      }
  }
}
