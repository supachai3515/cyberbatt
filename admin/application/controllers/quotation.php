<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require APPPATH . "/libraries/BaseController.php";
class quotation extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('quotation_model');
        $this->load->model('orders_model');
        $this->load->library('my_upload');
        $this->load->library('upload');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->quotation_model->get_quotation_count();
            $data["links_pagination"] = $this->pagination_compress("quotation/index", $count, $this->config->item("pre_page"));
            $data["quotation_list"] = $this->quotation_model->get_quotation($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data["content"] = "quotation/quotation";
            $data["header"] = $this->get_header("quotation");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->quotation_model->get_quotation_search();
            $data['quotation_list'] = $return_data['result_quotation'];
            $data['data_search'] = $return_data['data_search'];
         
            $data["content"] = "quotation/quotation";
            $data["header"] = $this->get_header("quotation");
            $this->load->view("template/layout_main", $data);
        }
    }


     // insert
     public function add($document_id)
     {
         $data["global"] = $this->global;
         $data["menu_id"] = $this->initdata_model->get_menu_id($this->router->fetch_class());
         $data["menu_list"] = $this->initdata_model->get_menu($data["global"]["menu_group_id"]);
         $data["access_menu"] = $this->isAccessMenu($data["menu_list"], $data["menu_id"]);
         if ($data["access_menu"]["is_access"]&&$data["access_menu"]["is_add"]) {
             date_default_timezone_set("Asia/Bangkok");
             //save document
             $quotation_id ="";
             $quotation_id = $this->quotation_model->save_quotation($document_id);
 
             if ($document_id !="") {
                 redirect("quotation/edit/".$quotation_id);
             } else {
                 redirect("quotation");
             }
         } else {
             // access denied
             $this->loadThis();
         }
     }

     
   //page edit
   public function edit($quotation_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
         
           $data['quotation_data'] = $this->quotation_model->get_quotation_id($quotation_id);
           $data['script_file']= "js/quotation_js";
           $data["content"] = "quotation/quotation_edit";
           $data["header"] = $this->get_header("quotations Edit");
           $this->load->view("template/layout_main", $data);
       }
   }

   // update
   public function update($quotation_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
           date_default_timezone_set("Asia/Bangkok");
           //save quotation
           $this->quotation_model->update_quotation($quotation_id);

           if ($quotation_id!="") {
               redirect('quotation/edit/'.$quotation_id);
           } else {
               redirect('quotation');
           }
       }
   }
 
    public function  quotation_invoice($quotation_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;


            $order_data = $this->quotation_model->get_quotation_id($quotation_id);
            $order_id = $order_data["order_id"];

            $data['quotation_data'] = $this->quotation_model->quotation_id($order_id);

            $data['orders_tem'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_data'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_detail'] = $this->orders_model->get_orders_detail_id($order_id);
            $data['orders_payment'] = $this->orders_model->get_payment_orders_id($order_id);
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data['order_status_history_list'] = $this->orders_model->get_order_status_history($order_id);
            $this->load->view('quotation/quotation_invoice_doc', $data);
        }
    }

    public function  quotation_invoice_searial($quotation_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;


            $order_data = $this->quotation_model->get_quotation_id($quotation_id);
            $order_id = $order_data["order_id"];

            $data['quotation_data'] = $this->quotation_model->quotation_id($order_id);

            $data['orders_tem'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_data'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_detail'] = $this->orders_model->get_orders_detail_id($order_id);
            $data['orders_payment'] = $this->orders_model->get_payment_orders_id($order_id);
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data['order_status_history_list'] = $this->orders_model->get_order_status_history($order_id);
            $data['serial'] =  $this->orders_model->get_product_serial_byorder($order_id);


            $this->load->view('quotation/quotation_invoice_doc_searial', $data);
        }
    }
   
}

/* End of file quotation.php */
/* Location: ./application/controllers/quotation.php */
