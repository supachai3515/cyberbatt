
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class invoice_model extends CI_Model
{
    public function get_invoice($start, $limit)
    { 
        $sql ="  SELECT  d.id, d.docno, d.order_id,
        d.create_date ,d.modified_date,
        DATE_FORMAT(d.due_date,'%Y-%m-%d') due_date,
        d.is_active, n.docno delivery_note_docno ,
n.id delivery_note_id ,
                        o.`name`,
                        o.address,
                        o.shipping,
                        o.email,
                        o.tel,
                        o.total,
        o.quantity,
        o.is_tax,
        o.tax_address,o.tax_company,o.tax_id,
                s.name order_status_name,
                        p.bank_name,
                        p.`comment`,
                        p.member_id,
                        p.amount,
                        DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
                        DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
                        p.create_date payment_create_date,
         
                u.`name` user_name
                FROM invoice d INNER JOIN orders o ON d.order_id = o.id
                        LEFT JOIN order_status s ON s.id =  o.order_status_id
                        LEFT JOIN   delivery_note n ON n.order_id =  o.id
                        LEFT JOIN  members m ON m.id = o.customer_id
                        LEFT JOIN payment p ON p.order_id = o.id AND p.line_number = 0
                LEFT JOIN tbl_users u ON u.userId = o.userId
                 
        ORDER BY  d.create_date DESC LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_invoice_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  invoice ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }


 
    public function get_invoice_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_invoice = array(
            'search' => $this->input->post('search'),
            'order_id' => $this->input->post('order_id')
        );

        $sql ="
        SELECT
        d.id, d.docno, d.order_id,
        d.create_date ,d.modified_date,
        DATE_FORMAT(d.due_date,'%Y-%m-%d') due_date,
        d.is_active, n.docno delivery_note_docno ,
        n.id delivery_note_id ,
                        o.`name`,
                        o.address,
                        o.shipping,
                        o.email,
                        o.tel,
                        o.total,
        o.quantity,
        o.is_tax,
        o.tax_address,o.tax_company,o.tax_id,
                s.name order_status_name,
                        p.bank_name,
                        p.`comment`,
                        p.member_id,
                        p.amount,
                        DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
                        DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
                        p.create_date payment_create_date,
         
                u.`name` user_name
                FROM invoice d INNER JOIN orders o ON d.order_id = o.id
                        LEFT JOIN order_status s ON s.id =  o.order_status_id
                        LEFT JOIN   delivery_note n ON n.order_id =  o.id
                        LEFT JOIN  members m ON m.id = o.customer_id
                        LEFT JOIN payment p ON p.order_id = o.id AND p.line_number = 0
                LEFT JOIN tbl_users u ON u.userId = o.userId
                 
        

				WHERE  1=1";

        if ($data_invoice['order_id'] !="") {
            $sql = $sql." AND d.order_id ='".$data_invoice['order_id']."'  ORDER BY d.create_date DESC";
        }else{
            $sql = $sql." AND (  d.id LIKE '%".$data_invoice['search']."%'
                            OR  d.docno LIKE '%".$data_invoice['search']."%')
                    ORDER BY d.create_date DESC
             ";
        }
 
        $re = $this->db->query($sql);
        $return_data['result_invoice'] = $re->result_array();
        $return_data['data_search'] = $data_invoice;
        $return_data['sql'] = $sql;
        return $return_data;

        
    }


    public function save_invoice($order_id)
    {

        $sql =" SELECT COUNT(id)+1 connt_id FROM invoice ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $countId =  $row['connt_id'];

        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $data_invoice = array(
            'is_active' => true,
            'order_id' => $order_id,
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'due_date' => date("Y-m-d"),
            'docno' => 'BN'.date("ym").str_pad($countId, 4, "0", STR_PAD_LEFT)
        );


        $this->db->insert('invoice', $data_invoice);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function invoice_id($order_id)
    {
        $sql =" SELECT o.* ,DATE_FORMAT(o.create_date,'%Y-%m-%d') create_date FROM  invoice o WHERE o.order_id = '".$order_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function get_invoice_id($invoice_id)
    {
        $sql =" SELECT d.*  FROM  invoice d WHERE  d.id = '".$invoice_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function update_invoice($slider_id)
    {
       
        date_default_timezone_set("Asia/Bangkok");
        $data_slider = array(
            'due_date' => $this->input->post('due_date'),
            'description' => $this->input->post('description'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$slider_id."'";
        $this->db->update("invoice", $data_slider, $where);
    }

}

/* End of file invoice_model.php */
/* Location: ./application/models/invoice_model.php */
