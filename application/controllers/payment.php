<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//call model inti 
		$this->load->model('initdata_model');
		$this->load->library('pagination');
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		//header meta tag 
		$data['header'] = array('title' => 'แจ้งชำระเงิน | '.$this->config->item('sitename'),
								'description' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();


		$data['content'] = 'payment';
		$this->load->view('template/layout', $data);
	}
	public function sendmail()
	{
		$data = json_decode(file_get_contents("php://input"));
	    $txtName = $data->txtName ;
	    $txtTel = $data->txtTel ;
	    $txtOrder = $data->txtOrder ;
	    $txtBank = $data->txtBank ;
	    $txtAmount = $data->txtAmount ;
	    $txtDate = $data->txtDate ;
	    $txtTime = $data->txtTime ;

	    $bodyText = " <p><strong>ชื่อผู้สั่งสินค้า : </strong> ".$txtName.'</p>';
	    $bodyText = $bodyText." <p><strong>เบอร์ติดต่อ : </strong> ".$txtTel.'</p>';
	    $bodyText = $bodyText." <p><strong>เลขที่ใบสั่งซื้อ : </strong> ".$txtOrder.'</p>';
	    $bodyText = $bodyText." <p><strong>ธนาคาร</strong> : ".$txtBank.'</p>';
	    $bodyText = $bodyText." <p><strong>จำนวนเงินที่โอน</strong> : ".$txtAmount.'</p>';
	    $bodyText = $bodyText." <p><strong>วันที่โอน </strong> : ".$txtDate.'</p>';
	    $bodyText = $bodyText." <p><strong>เวลาโอน </strong> : ".$txtTime.'</p>';
	    $bodyText = $bodyText." <p><strong>วันที่แจ้ง </strong> : ".date("Y-m-d H:i:s") .'</p>';


	    if(isset($data->txtName)){
	    	//sendmail
		    $email_config = Array(
	            'protocol'  => 'smtp',
	            'smtp_host' => 'ssl://smtp.googlemail.com',
	            'smtp_port' => '465',
	            'smtp_user' => $this->config->item('email_noreply'),
	            'smtp_pass' => $this->config->item('pass_mail_noreply'),
	            'mailtype'  => 'html',
	            'starttls'  => true,
	            'newline'   => "\r\n"
	        );

	        $this->load->library('email', $email_config);
	        $this->email->from($this->config->item('email_noreply'), 'แแจ้งการโอนเงินผ่านเว็บ เลขที่ใบสั่งซื้อ : '.$txtOrder);
	        $this->email->to($this->config->item('email_owner'));
	        $this->email->subject( 'คุณ ' . $txtName . ' ได้ทำการโอนเงินผ่านทางเว็บไซต์');
	        $this->email->message($bodyText);
	        if($this->email->send())
		     {
		     		$re['error'] = false;
					$re['message'] = 'เราได้รับการแจ้งเชำระเงินเรียบร้อยแล้ว';
					print json_encode($re);
		     
		     }
		     else
		    {
		    	
		       show_error($this->email->print_debugger());
		    }

	    }
	    else{
	    		$re['error'] = true;
				$re['message'] = 'เกิดข้อผิดผลาด กรุณาแจ้งยืนยันอีกครั้ง';
				print json_encode($re);

	    }

       
	}

	public function save()
	{

		//header meta tag 
		$data['header'] = array('title' => 'แจ้งชำระเงิน | '.$this->config->item('sitename'),
								'description' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline'),
								'author' => $this->config->item('author'),
								'keyword' =>  'แจ้งชำระเงิน | '.$this->config->item('tagline') );

		//get menu database 
		$this->load->model('initdata_model');
		$data['menus_list'] = $this->initdata_model->get_menu();
		$data['menu_type'] = $this->initdata_model->get_type();
		$data['menu_brands'] = $this->initdata_model->get_brands();
		$txtName = $this->input->post('txtName');
		if	(isset($txtName))
		{

			$txtName =  $this->input->post('txtName');
		    $txtTel = $this->input->post('txtTel');
		    $txtOrder = $this->input->post('txtOrder');
		    $txtBank = $this->input->post('txtBank');
		    $txtAmount = $this->input->post('txtAmount');
		    $txtDate = $this->input->post('txtDate');
		    $txtTime = $this->input->post('txtTime');

		    $bodyText = "<strong>ชื่อผู้สั่งสินค้า : </strong> ".$txtName.'<br>';
		    $bodyText = $bodyText."<strong>เบอร์ติดต่อ : </strong> ".$txtTel.'<br>';
		    $bodyText = $bodyText."<strong>เลขที่ใบสั่งซื้อ : </strong> ".$txtOrder.'<br>';
		    $bodyText = $bodyText."<strong>ธนาคาร</strong> : ".$txtBank.'<br>';
		    $bodyText = $bodyText."<strong>จำนวนเงินที่โอน</strong> : ".$txtAmount.'<br>';
		    $bodyText = $bodyText."<strong>วันที่โอน </strong> : ".$txtDate.'<br>';
		    $bodyText = $bodyText."<strong>เวลาโอน </strong> : ".$txtTime.'<br>';
		    $bodyText = $bodyText."<strong>วันที่แจ้ง </strong> : ".date("Y-m-d H:i:s") .'<br>';

		}

        $config['upload_path']          = './uploads/payment/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 3000;
        $config['max_width']            = 2048;
        $config['max_height']           = 3000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
        		$data['is_error'] = true;
                $data['error'] = array('error' => $this->upload->display_errors());
                $bodyText = $bodyText."<strong>Image Error</strong> : ".$data['error']."<br>";
                //$this->load->view('template/layout', $data );
        }
        else
        {
        	    $data['is_error'] = false;
                $data = array('upload_data' => $this->upload->data());
                $bodyText = $bodyText.'<img src="http://cyber.wisadev.com/uploads/payment/'.$data['upload_data']['file_name'] .'" class="img-responsive" alt="Image"width="100%"><br>';
                //$this->load->view('template/layout', $data );
        }

	   if(isset($txtName))
	   {
	    	//sendmail
		    $email_config = Array(
	            'protocol'  => 'smtp',
	            'smtp_host' => 'ssl://smtp.googlemail.com',
	            'smtp_port' => '465',
	            'smtp_user' => $this->config->item('email_noreply'),
	            'smtp_pass' => $this->config->item('pass_mail_noreply'),
	            'mailtype'  => 'html',
	            'starttls'  => true,
	            'newline'   => "\r\n"
	        );

	        $this->load->library('email', $email_config);
	        $this->email->from($this->config->item('email_noreply'), 'แแจ้งการโอนเงินผ่านเว็บ เลขที่ใบสั่งซื้อ : '.$txtOrder);
	        $this->email->to($this->config->item('email_owner'));
	        $this->email->subject( 'คุณ ' . $txtName . ' ได้ทำการโอนเงินผ่านทางเว็บไซต์');
	        $this->email->message($bodyText);
	        if($this->email->send())
		     {
		     		$re['error'] = false;
					$re['message'] = 'เราได้รับการแจ้งเชำระเงินเรียบร้อยแล้ว';
					//print json_encode($re);
		     
		     }
		     else {
		     		$data['is_error'] = true;
			}
	    }

        $data['txt_res'] = $bodyText;
        $data['content'] = 'payment';
        $this->load->view('template/layout', $data );
       
	}

}

/* End of file payment.php */
/* Location: ./application/controllers/payment.php */