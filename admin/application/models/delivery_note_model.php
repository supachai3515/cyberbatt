
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class delivery_note_model extends CI_Model
{
    public function get_delivery_note($start, $limit)
    { 
        $sql ="  SELECT  d.id, d.docno, d.order_id,
        d.create_date ,d.modified_date,
        DATE_FORMAT(d.due_date,'%Y-%m-%d') due_date,
        d.is_active, i.docno invoice_docno ,
i.id invoice_id ,
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
                FROM delivery_note d INNER JOIN orders o ON d.order_id = o.id
                        LEFT JOIN order_status s ON s.id =  o.order_status_id
                        LEFT JOIN invoice i ON i.order_id =  o.id
                        LEFT JOIN  members m ON m.id = o.customer_id
                        LEFT JOIN payment p ON p.order_id = o.id AND p.line_number = 0
                LEFT JOIN tbl_users u ON u.userId = o.userId
                 
        ORDER BY o.date DESC LIMIT " . $start . "," . $limit;
        $re = $this->db->query($sql);
        return $re->result_array();
    }

    public function get_delivery_note_count()
    {
        $sql =" SELECT COUNT(id) as connt_id FROM  delivery_note ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return  $row['connt_id'];
    }




    public function get_delivery_note_search()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data_delivery_note = array(
            'search' => $this->input->post('search'),
            'order_id' => $this->input->post('order_id')
        );

        $sql =" SELECT  d.id, d.docno, d.order_id,
        d.create_date ,d.modified_date,
        DATE_FORMAT(d.due_date,'%Y-%m-%d') due_date,
        d.is_active, i.docno invoice_docno ,
i.id invoice_id ,
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
                FROM delivery_note d INNER JOIN orders o ON d.order_id = o.id
                        LEFT JOIN order_status s ON s.id =  o.order_status_id
                        LEFT JOIN invoice i ON i.order_id =  o.id
                        LEFT JOIN  members m ON m.id = o.customer_id
                        LEFT JOIN payment p ON p.order_id = o.id AND p.line_number = 0
                LEFT JOIN tbl_users u ON u.userId = o.userId
        

				WHERE  1=1";

        if ($data_delivery_note['order_id'] !="") {
            $sql = $sql." AND d.order_id ='".$data_delivery_note['order_id']."'   ORDER BY d.create_date DESC , o.date DESC";
        }else{
            $sql = $sql." AND ( d.id LIKE '%".$data_delivery_note['search']."%'
            OR  d.docno LIKE '%".$data_delivery_note['search']."%') 
             ORDER BY d.create_date DESC , o.date DESC
            ";
        }

      



        $re = $this->db->query($sql);
        $return_data['result_delivery_note'] = $re->result_array();
        $return_data['data_search'] = $data_delivery_note;
        $return_data['sql'] = $sql;
        return $return_data;

        
    }


    public function save_delivery_note($order_id)
    {

        $sql =" SELECT IFNULL(COUNT(id)+1 , 1) as connt_id FROM  delivery_note ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $countId =  $row['connt_id'];

        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $data_delivery_note = array(
            'is_active' => true,
            'order_id' => $order_id,
            'create_date' => date("Y-m-d H:i:s"),
            'modified_date' => date("Y-m-d H:i:s"),
            'due_date' => date("Y-m-d"),
            'docno' => 'DO'.date("ym").str_pad($countId, 4, "0", STR_PAD_LEFT)
        );


        $this->db->insert('delivery_note', $data_delivery_note);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function delivery_note_id($order_id)
    {
        $sql =" SELECT o.* ,DATE_FORMAT(o.create_date,'%Y-%m-%d') create_date FROM  delivery_note o WHERE o.order_id = '".$order_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function get_delivery_note_id($delivery_note_id)
    {
        $sql =" SELECT d.*  FROM  delivery_note d WHERE  d.id = '".$delivery_note_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row;
    }

    public function update_delivery_note($slider_id)
    {
       
        date_default_timezone_set("Asia/Bangkok");
        $data_slider = array(
            'due_date' => $this->input->post('due_date'),
            'description' => $this->input->post('description'),
            'modified_date' => date("Y-m-d H:i:s"),
            'is_active' => $this->input->post('isactive')
        );
        $where = "id = '".$slider_id."'";
        $this->db->update("delivery_note", $data_slider, $where);
    }

}

/* End of file delivery_note_model.php */
/* Location: ./application/models/delivery_note_model.php */
