
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {


	public function get_orders( $start, $limit)
	{

	    $sql ="  SELECT p.* , os.name order_status_name FROM  orders p INNER JOIN order_status os ON os.id =  p.order_status_id
	    		 WHERE  p.is_reservations = '0' ORDER BY p.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_orders_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  orders p WHERE  p.is_reservations = '0'"; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_orders_id($orders_id)
	{
		$sql =" SELECT p.* , os.name order_status_name FROM  orders p INNER JOIN order_status os ON os.id =  p.order_status_id
				 WHERE p.id = '".$orders_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row;
	}

	public function get_orders_detail_id($orders_id)
	{
		$sql ="SELECT od.* ,  IFNULL(p.sku,'') sku, IFNULL(p.name,'') product_name FROM order_detail od 
		LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = '".$orders_id."'"; 

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}

	public function get_order_status()
	{
		$sql ="SELECT * FROM order_status"; 

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}//

	public function get_order_status_history($orders_id)
	{
		$sql =" SELECT oh.* , os.name order_status_name 
				from order_status_history  oh 
				LEFT JOIN order_status os ON oh.order_status_id = os.id
				where oh.order_id ='".$orders_id."' ORDER BY oh.create_date DESC"; 

		$query = $this->db->query($sql);
		$row = $query->result_array();
		return $row;
	}
	

	public function update_status($orders_id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_order_status = array(
			'order_status_id' => $this->input->post('select_status'),
			'description' => $this->input->post('description'),
			'order_id' => $orders_id,
			'create_date' => date("Y-m-d H:i:s"),						
		);
		$this->db->insert("order_status_history", $data_order_status);


		$data_order = array(
			'order_status_id' => $this->input->post('select_status')				
		);

		$where = "id = '".$orders_id."'"; 
		$this->db->update("orders", $data_order, $where);

	}

	public function update_tracking($orders_id)
	{
		$data_order = array(
			'trackpost' => $this->input->post('tracking')				
		);

		$where = "id = '".$orders_id."'"; 
		$this->db->update("orders", $data_order, $where);

	}



	 public function get_orders_search()
	{
		date_default_timezone_set("Asia/Bangkok");
		$data_orders = array(
			'search' => $this->input->post('search'),
			'order_id' => $this->input->post('order_id')	
		);

		$sql ="SELECT p.* , os.name order_status_name FROM  orders p INNER JOIN order_status os ON os.id =  p.order_status_id
				 WHERE  1=1 AND p.is_reservations = '0' ";

				 if($data_orders['order_id'] !="")
				 { 
				 	$sql = $sql." AND p.id ='".$data_orders['order_id']."'";
				 }

				 if($this->input->post('select_status') !="0")
				 { 
				 	$sql = $sql." AND os.id ='".$this->input->post('select_status')."'";
				 }
				
				 $sql = $sql." AND (p.name LIKE '%".$data_orders['search']."%' 
								 OR  p.id LIKE '%".$data_orders['search']."%' 
								 OR  p.trackpost LIKE '%".$data_orders['search']."%') ";
				 


		$re = $this->db->query($sql);
		$return_data['result_orders'] = $re->result_array();
		$return_data['data_search'] = $data_orders;
		$return_data['sql'] = $sql;
		return $return_data;
	}



}

/* End of file orders_model.php */
/* Location: ./application/models/orders_model.php */