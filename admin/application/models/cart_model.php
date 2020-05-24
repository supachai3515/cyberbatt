<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cart_model extends CI_Model {
	// Updated the shopping cart
	function validate_update_cart(){

		// Get the total number of items in cart
		$total = $this->cart->total_items();

		// Retrieve the posted information
		$item = $this->input->post('rowid');
	    $qty = $this->input->post('qty');
	    $product_id = $this->input->post('product_id');
	    $return_str ="";

		// Cycle true all items and update them
		for($i=0;$i < count($product_id);$i++)
		{
			
			$chk_qty =0;
			$sql   = "SELECT * FROM products WHERE is_active = 1 AND stock > 0 AND id = '".$product_id[$i]."'";
	        $query = $this->db->query($sql);
	        $row   = $query->row_array();
	        if(isset($row['id'])) {
	        	if($row['stock'] >= $qty[$i]) {
	        		$chk_qty = $qty[$i] ;
	        	}
	        	else {

	        		$chk_qty = $row['stock'] ;
	        		$return_str = $return_str.$row['name']." : สต็อกคงเหลือ = ".$row['stock']. " ";
	        	}
	        }
			// Create an array with the products rowid's and quantities.
			$data = array(
               'rowid' => $item[$i],
               'qty'   => $chk_qty 
            );

            // Update the cart with the new information
			$this->cart->update($data);
		}
		return $return_str;

	}

	// Add an item to the cart
	function validate_add_cart_item(){

		$id = $this->input->post('product_id'); // Assign posted product_id to $id
		$cty = $this->input->post('quantity'); // Assign posted quantity to $cty

		$this->db->where('id', $id); // Select where id matches the posted id
		$query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1

		// Check if a row has been found
		if($query->num_rows > 0){

			foreach ($query->result() as $row)
			{
			    $data = array(
               		'id'      => $id,
               		'qty'     => $cty,
               		'price'   => $row->price,
               		'name'    => $row->name
            	);

				$this->cart->insert($data);

				return TRUE;
			}

		// Nothing found! Return FALSE!
		}else{
			return FALSE;
		}
	}

	// Needed?
	//function cart_content(){
	//	return $this->cart->total();
	//}

}


/* End of file cart_model.php */
/* Location: ./application/models/cart_model.php */
