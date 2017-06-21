
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product_serial_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('Initdata_model');
	}

	public function get_product_serial( $start, $limit)
	{

	    $sql =" SELECT sn.*, p.sku, sn.serial_number ,r.doc_no receive_id ,sn.create_date ,sh.comment status_name , sh.create_date create_date_status,
			p.`name` product_name ,r.create_date receive_date 
					FROM product_serial sn 
				LEFT JOIN receive r ON r.id = sn.receive_id
				LEFT JOIN products p ON p.id = sn.product_id
        	INNER JOIN serial_history sh ON sh.serial_number = sn.serial_number AND sn.product_id = sh.product_id AND sh.create_date = (
					SELECT MAX(create_date)
					FROM serial_history AS b
					WHERE b.serial_number = sn.serial_number AND b.product_id = sh.product_id 
			) LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}


	public function get_product_serial_count()
	{
		$sql =" SELECT COUNT(serial_number) as connt_id FROM  product_serial p"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


    public function get_product_serial_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_product_serial = array(
			'search' => $this->input->post('search')		
		);

		$sql ="SELECT sn.*, p.sku, sn.serial_number ,r.doc_no receive_id ,sn.create_date ,sh.comment status_name , sh.create_date create_date_status,
				p.`name` product_name ,r.create_date receive_date 
						FROM product_serial sn 
					LEFT JOIN receive r ON r.id = sn.receive_id
					LEFT JOIN products p ON p.id = sn.product_id
	        	INNER JOIN serial_history sh ON sh.serial_number = sn.serial_number AND sn.product_id = sh.product_id AND sh.create_date = (
						SELECT MAX(create_date)
						FROM serial_history AS b
						WHERE b.serial_number = sn.serial_number AND b.product_id = sh.product_id 
				)
				WHERE sn.serial_number  LIKE '%".$data_product_serial['search']."%' OR   p.sku LIKE '%".$data_product_serial['search']."%'

				";
		$re = $this->db->query($sql);
		$return_data['result_product_serial'] = $re->result_array();
		$return_data['data_search'] = $data_product_serial;
		$return_data['sql'] = $sql;
		return $return_data;
	}

	public function get_product_serial_history($product_id, $serial_number)
	{
		 $sql =" SELECT h.* , h.`comment` status_name FROM serial_history h 
				WHERE  product_id ='".$product_id."' AND serial_number ='".$serial_number."'  
				ORDER BY h.create_date DESC";
		$re = $this->db->query($sql);
		return $re->result_array();
	}





}

/* End of file product_serial_model.php */
/* Location: ./application/models/product_serial_model.php */