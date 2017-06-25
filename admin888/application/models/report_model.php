
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function getOrder($obj = ''){
		if(empty($obj['list_category']) == 1 && $obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif(empty($obj['list_category']) == 1 && $obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif(empty($obj['list_category']) == 1 && $obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif(empty($obj['list_category']) != 1 && $obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and payment.bank_name = '".strip_tags(trim($obj['list_category']))."' and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}
		
		/*CheckBank*/
		$check = $this->input->post("checkbank");
		if($check == 0){
			$search = ',sum(payment.amount) as sum';
			$checkBank = 'group by payment.bank_name';
		}else{
			$search = '';
			$checkBank = '';
		}
		
		
		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *".$search." from payment left join order_status_history on(order_status_history.order_id = payment.order_id) where order_status_history.order_status_id = 2 ".$dataSearch." ".$checkBank."")->result_array();
		}else{
			$query = $this->db->query("select *".$search." from payment left join order_status_history on(order_status_history.order_id = payment.order_id) where order_status_history.order_status_id = 2 and DATE_FORMAT(payment.inform_date_time,'%Y-%m-%d') Between '".DATE."' and '".DATE."' ".$checkBank."")->result_array();
		}
		return $query;
	}
	
	function getProduct($obj = ''){
		if($obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}
		
		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *,sum(order_detail.total) as sum_total,sum(order_detail.quantity) as ordetailsQTY,products.name as proname,order_detail.vat as ordetailsVAC,order_detail.total as ordetailstotal,product_type.name as typename,product_brand.name as brandname from order_detail left join products on(products.id = order_detail.product_id) left join orders on(orders.id = order_detail.order_id) left join order_status_history on(order_status_history.order_id = orders.order_status_id) left join product_type on(product_type.id = products.product_type_id) left join product_brand on(product_brand.id = products.product_brand_id) where order_status_history.order_status_id = 4 ".$dataSearch." group by order_detail.product_id order by ordetailsQTY DESC")->result_array();
		}else{
			$query = $this->db->query("select *,sum(order_detail.total) as sum_total,sum(order_detail.quantity) as ordetailsQTY,products.name as proname,order_detail.vat as ordetailsVAC,order_detail.total as ordetailstotal,product_type.name as typename,product_brand.name as brandname from order_detail left join products on(products.id = order_detail.product_id) left join orders on(orders.id = order_detail.order_id) left join order_status_history on(order_status_history.order_id = orders.order_status_id) left join product_type on(product_type.id = products.product_type_id) left join product_brand on(product_brand.id = products.product_brand_id) where order_status_history.order_status_id = 4 and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."' group by order_detail.product_id order by ordetailsQTY DESC")->result_array();
		}
		return $query;
	}
	
	function getPrice($obj = ''){
		if($obj['dateStart'] == '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] == ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".DATE."'";
		}elseif($obj['dateStart'] != '' && $obj['dateEnd'] != ''){
			$dataSearch = "and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".$obj['dateStart']."' and '".$obj['dateEnd']."'";
		}
		
		if($this->input->get("method") == 'post'){
			$query = $this->db->query("select *,DATE_FORMAT(orders.date,'%Y-%m-%d') as orDATE,sum(orders.total) as sum_total,sum(orders.quantity) as orQTY,sum(orders.vat) as orVAT from orders left join order_status_history on(order_status_history.order_id = orders.order_status_id) where order_status_history.order_status_id = 4 ".$dataSearch." group by DATE_FORMAT(orders.date,'%Y-%m-%d')")->result_array();
		}else{
			$query = $this->db->query("select *,sum(orders.total) as sum_total from orders left join order_status_history on(order_status_history.order_id = orders.order_status_id) where order_status_history.order_status_id = 4 and DATE_FORMAT(orders.date,'%Y-%m-%d') Between '".DATE."' and '".DATE."' group by DATE_FORMAT(orders.date,'%Y-%m-%d')")->result_array();
		}
		return $query;
	}
	
	/*select *,sum(orders.total) as sum_total,sum(orders.quantity) as quantity,sum(orders.vat) as vat
from orders 
left join order_status_history on(order_status_history.order_id = orders.order_status_id) 
where order_status_history.order_status_id = 4 and 
DATE_FORMAT(orders.date,'%Y-%m-%d') Between '2017-05-05' and '2017-05-10' group by orders.date*/
	
}
