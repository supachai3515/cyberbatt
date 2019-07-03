<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class invoice extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('invoice_model');
        $this->load->model('orders_model');
        $this->load->model('delivery_note_model');
        
        $this->load->library('my_upload');
        $this->load->library('upload');
        $this->isLoggedIn();
    }

    //page view
    public function index($page=0)
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $count = $this->invoice_model->get_invoice_count();
            $data["links_pagination"] = $this->pagination_compress("invoice/index", $count, $this->config->item("pre_page"));
            $data["invoice_list"] = $this->invoice_model->get_invoice($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data["content"] = "invoice/invoice";
            $data["header"] = $this->get_header("invoice");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->invoice_model->get_invoice_search();
            $data['invoice_list'] = $return_data['result_invoice'];
            $data['data_search'] = $return_data['data_search'];
         
            $data["content"] = "invoice/invoice";
            $data["header"] = $this->get_header("invoice");
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
             $invoice_id ="";
             $invoice_id = $this->invoice_model->save_invoice($document_id);
 
             if ($document_id !="") {
                 redirect("invoice/edit/".$invoice_id);
             } else {
                 redirect("invoice");
             }
         } else {
             // access denied
             $this->loadThis();
         }
     }

     
   //page edit
   public function edit($invoice_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
         
           $data['invoice_data'] = $this->invoice_model->get_invoice_id($invoice_id);
           $data['script_file']= "js/invoice_js";
           $data["content"] = "invoice/invoice_edit";
           $data["header"] = $this->get_header("invoices Edit");
           $this->load->view("template/layout_main", $data);
       }
   }

   // update
   public function update($invoice_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
           date_default_timezone_set("Asia/Bangkok");
           //save invoice
           $this->invoice_model->update_invoice($invoice_id);

           if ($invoice_id!="") {
               redirect('invoice/edit/'.$invoice_id);
           } else {
               redirect('invoice');
           }
       }
   }
 
    public function  invoice_doc($invoice_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;


            $order_data = $this->invoice_model->get_invoice_id($invoice_id);
            $order_id = $order_data["order_id"];

            $data['delivery_note_data'] = $this->delivery_note_model->delivery_note_id($order_id);
            
            $data['invoice_data'] = $this->invoice_model->invoice_id($order_id);

            $data['orders_tem'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_data'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_detail'] = $this->orders_model->get_orders_detail_id($order_id);
            $data['orders_payment'] = $this->orders_model->get_payment_orders_id($order_id);
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data['order_status_history_list'] = $this->orders_model->get_order_status_history($order_id);
            $this->load->view('invoice/invoice_doc', $data);
        }
    }
   
}

/* End of file invoice.php */
/* Location: ./application/controllers/invoice.php */
