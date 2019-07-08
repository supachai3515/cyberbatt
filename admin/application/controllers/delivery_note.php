<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . "/libraries/BaseController.php";
class delivery_note extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model('delivery_note_model');
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
            $count = $this->delivery_note_model->get_delivery_note_count();
            $data["links_pagination"] = $this->pagination_compress("delivery_note/index", $count, $this->config->item("pre_page"));
            $data["delivery_note_list"] = $this->delivery_note_model->get_delivery_note($page, $this->config->item("pre_page"));
            $data["links_pagination"] = $this->pagination->create_links();

            $data["content"] = "delivery_note/delivery_note";
            $data["header"] = $this->get_header("delivery_note");
            $this->load->view("template/layout_main", $data);
        }
    }


    //page search
    public function search()
    {
        $data = $this->get_data_check("is_view");
        if (!is_null($data)) {
            $return_data = $this->delivery_note_model->get_delivery_note_search();
            $data['delivery_note_list'] = $return_data['result_delivery_note'];
            $data['data_search'] = $return_data['data_search'];
         
            $data["content"] = "delivery_note/delivery_note";
            $data["header"] = $this->get_header("delivery_note");
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
             $delivery_note_id ="";
             $delivery_note_id = $this->delivery_note_model->save_delivery_note($document_id);
 
             if ($document_id !="") {
                 redirect("delivery_note/edit/".$delivery_note_id);
             } else {
                 redirect("delivery_note");
             }
         } else {
             // access denied
             $this->loadThis();
         }
     }

     
   //page edit
   public function edit($delivery_note_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
         
           $data['delivery_note_data'] = $this->delivery_note_model->get_delivery_note_id($delivery_note_id);
           $data['script_file']= "js/delivery_note_js";
           $data["content"] = "delivery_note/delivery_note_edit";
           $data["header"] = $this->get_header("delivery_notes Edit");
           $this->load->view("template/layout_main", $data);
       }
   }

   // update
   public function update($delivery_note_id)
   {
       $data = $this->get_data_check("is_edit");
       if (!is_null($data)) {
           date_default_timezone_set("Asia/Bangkok");
           //save delivery_note
           $this->delivery_note_model->update_delivery_note($delivery_note_id);

           if ($delivery_note_id!="") {
               redirect('delivery_note/edit/'.$delivery_note_id);
           } else {
               redirect('delivery_note');
           }
       }
   }
 
    public function  delivery_invoice($delivery_note_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;


            $order_data = $this->delivery_note_model->get_delivery_note_id($delivery_note_id);
            $order_id = $order_data["order_id"];

            $data['delivery_note_data'] = $this->delivery_note_model->delivery_note_id($order_id);

            $data['orders_tem'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_data'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_detail'] = $this->orders_model->get_orders_detail_id($order_id);
            $data['orders_payment'] = $this->orders_model->get_payment_orders_id($order_id);
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data['order_status_history_list'] = $this->orders_model->get_order_status_history($order_id);
            $this->load->view('delivery_note/delivery_invoice_doc', $data);
        }
    }

    public function  delivery_invoice_searial($delivery_note_id, $print_f = 0)
    {
        $data = $this->get_data_check("is_edit");
        if (!is_null($data)) {
            $data['print_f'] = $print_f;


            $order_data = $this->delivery_note_model->get_delivery_note_id($delivery_note_id);
            $order_id = $order_data["order_id"];

            $data['delivery_note_data'] = $this->delivery_note_model->delivery_note_id($order_id);

            $data['orders_tem'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_data'] = $this->orders_model->get_orders_id($order_id);
            $data['orders_detail'] = $this->orders_model->get_orders_detail_id($order_id);
            $data['orders_payment'] = $this->orders_model->get_payment_orders_id($order_id);
            $data['order_status_list'] = $this->orders_model->get_order_status();
            $data['order_status_history_list'] = $this->orders_model->get_order_status_history($order_id);
            $data['serial'] =  $this->orders_model->get_product_serial_byorder($order_id);


            $this->load->view('delivery_note/delivery_invoice_doc_searial', $data);
        }
    }
   
}

/* End of file delivery_note.php */
/* Location: ./application/controllers/delivery_note.php */
