
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {


	public function get_orders( $start, $limit)
	{

	    $sql ="  SELECT o.* , s.name order_status_name,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
				p.create_date payment_create_date
				FROM  orders o 
				LEFT JOIN order_status s ON s.id =  o.order_status_id
				LEFT JOIN  members m ON m.id = o.customer_id 
				LEFT JOIN payment p ON p.order_id = o.id ORDER BY o.id DESC LIMIT " . $start . "," . $limit;
		$re = $this->db->query($sql);
		return $re->result_array();

	}

	public function get_orders_count()
	{
		$sql =" SELECT COUNT(id) as connt_id FROM  orders "; 
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return  $row['connt_id'];
	
	}


	public function get_orders_id($orders_id)
	{
		$sql =" SELECT o.* , s.name order_status_name,
				p.bank_name,
				p.`comment`,
				p.member_id,
				p.amount,
				DATE_FORMAT(p.inform_date_time,'%Y-%m-%d') inform_date,
				DATE_FORMAT(p.inform_date_time,'%H:%i') inform_time,
				p.create_date payment_create_date
				FROM  orders o 
				LEFT JOIN order_status s ON s.id =  o.order_status_id
				LEFT JOIN  members m ON m.id = o.customer_id 
				LEFT JOIN payment p ON p.order_id = o.id
			  WHERE o.id = '".$orders_id."'"; 

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



		if($this->input->post('select_status')== "2"){
			// remove stock

			$rows = $this->get_orders_detail_id($orders_id);
			foreach ($rows as $row) {

				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND order_id ='".$orders_id."'"; 

				$query = $this->db->query($sql);
				$r = $query->row_array();
				if( $r['connt_id']==0 ) {
					$data_stock = array(
						'product_id' =>  $row['product_id'],
						'order_id' => $orders_id,
						'number'=> $row['quantity']
					);
					$this->db->insert("stock", $data_stock);

					//update product
					$sql_update ="UPDATE products SET stock = stock-".$row['quantity']." WHERE id =".$row['product_id']." ";
					$this->db->query($sql_update);
				}
			} 
		}

		if($this->input->post('select_status')== "6"){

			$rows = $this->get_orders_detail_id($orders_id);
			foreach ($rows as $row) {
				$sql =" SELECT COUNT(product_id) as connt_id FROM  stock WHERE product_id ='".$row['product_id']."' AND order_id ='".$orders_id."'"; 

				$query = $this->db->query($sql);
				$r = $query->row_array();
				if( $r['connt_id']>0 ) {
					$data_stock = array(
						'product_id' =>  $row['product_id'],
						'order_id' => $orders_id,
						'number'=> $row['quantity']
					);
					$this->db->delete("stock", $data_stock);

					//update product
					$sql_update ="UPDATE products SET stock = stock+".$row['quantity']." WHERE id =".$row['product_id']." ";
					$this->db->query($sql_update);
				}
			}

		}

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

		$sql ="SELECT p.* , os.name order_status_name FROM  orders p INNER JOIN order_status os ON os.id =  p.order_status_id WHERE  1=1";

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


	public function get_product_serial($product_id , $receive_id)
	{
		$sql =" SELECT ps.* , p.`name` product_name ,p.sku FROM product_serial ps INNER JOIN products p ON p.id = ps.product_id 
				where ps.product_id = '".$product_id."' 
				AND ps.order_id = '".$receive_id."' 
				AND ps.is_active = 1 
		        ORDER BY ps.line_number ;"; 
		$re = $this->db->query($sql);
		return $re->result_array();
	}




	public function update_img($order_id, $image_name ,$feild)
	{
		$data_product = array(
			$feild => $image_name,
		);

		$where = "id = '".$order_id."'"; 
		$this->db->update('orders', $data_product,$where );
		
	}


	public function update_invoice($po_orders_id)
	{	
		date_default_timezone_set("Asia/Bangkok");
		$data_order = array(
			'is_invoice' => $this->input->post('is_invoice'),	
			'invoice_date' => date("Y-m-d H:i:s"),
			'invoice_docno' => 'IN'.date("ymd").str_pad($po_orders_id, 4, "0", STR_PAD_LEFT)	
		);

		$where = array('id' => $po_orders_id);
		$this->db->update("orders", $data_order, $where);
		$this->reset_order($po_orders_id);
	}


}

/* End of file orders_model.php */
/* Location: ./application/models/orders_model.php */