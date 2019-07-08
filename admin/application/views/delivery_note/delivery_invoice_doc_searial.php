<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ใบส่งสินค้า <?php echo $orders_data['invoice_docno']." ".$orders_data["name"];?></title>

		<!-- Bootstrap CSS -->
		<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body ng-app="myApp" ng-controller="mainCtrl">
	<div style="padding-top:30px;"></div>
	<div class="container fix-container" ng-init="orderSenmailInit()">
		<div class="row">

            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            		<img src="<?php echo $this->config->item('url_img');?>theme/img/logo/logo.png" style="width: 200px"/>
            		<h4>บริษัท ไซเบอร์ แบต จำกัด (สำนักงานใหญ่)</h4>
					  396 ชั้น 1 โซน เอ ซ.ลาดพร้าว 94 (ปัญจมิตร) ถ.ลาดพร้าว <br>
					  แขวงพลับพลา เขตวังทองหลาง กทม. 10310 <br>
					  โทรศัพท์มือถือ 081-754-7565<br>
			  		 <strong>เลขประจำตัวผู้เสียภาษี 0105553076314</strong>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
             

        				<h3>ใบส่งสินค้า<br>
        				 <?php echo  $delivery_note_data['docno'];?> </h3>
                        <strong>วันที่ออก <?php echo date("Y-m-d", strtotime($delivery_note_data['create_date']));?></strong><br/>
                        <strong>วันครบกำหนด <?php echo date("Y-m-d", strtotime($delivery_note_data['due_date']));?></strong><br/>
                        <strong>Ref. #<?php echo $orders_data['id']?></strong><br/>

 


            	</div>
		</div>
		<div class="row" style="padding-top:10px;">
		<?php if ($orders_data['is_tax'] != 1): ?>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default height">
								<div class="panel-heading">ลูกค้า</div>
								<div class="panel-body">
										<strong>ชื่อ: </strong><?php echo $orders_data["name"];?><br>
										<strong>ที่อยู่: </strong><?php echo $orders_data["address"];?><br>
										<strong>เบอร์ติดต่อ: </strong><?php echo $orders_data["tel"];?><br>
										<strong>อีเมล์: </strong><?php echo $orders_data["email"];?>

								</div>
						</div>

			</div>
		<?php endif; ?>

            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            	<?php if($orders_data['is_tax'] == 1 ) { ?>
            		<div class="panel panel-default height">
                        <div class="panel-heading">ที่อยู่สำหรับออกใบกำกับภาษี</div>
                        <div class="panel-body">
                            <strong>ชื่อบริษัท / ร้าน: </strong><?php echo $orders_data["tax_company"];?><br>
                            <strong>ที่อยู่: </strong><?php echo $orders_data["tax_address"];?><br>
                            <strong>เบอร์ติดต่อ: </strong><?php echo $orders_data["tel"];?><br>
                            <strong>อีเมล์: </strong><?php echo $orders_data["email"];?><br>
                            <strong>เลขประจำตัวผู้เสียภาษี: </strong><?php echo $orders_data["tax_id"];?>

                        </div>
                    </div>
		  		<?php } ?>
            	</div>
		</div>
 
	    <div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-body">
	                    <div class="box-body table-responsive">
	                        <table class="table">
	                            <thead>
	                                <tr>
	                                    <td class="product-id">ID สินค้า</td>
	                                    <td class="text-left">รายละเอียด</td>
	                               
	                                    <td class="text-right" width="70">จำนวน</td>
	                                  
	                                </tr>
	                            </thead>
	                            <tbody>
	                            <?php foreach ($orders_detail as $value): ?>
	                            	 <tr>
										<td  class="text-left"> <strong><?php echo $value['sku'] ?></strong></td>

                                        <td class="text-left"> <strong><?php echo $value['product_name'] ?></strong>
                                        
                                        
                                        <div class="row">
                                            
        
                                            <?php foreach ($serial as $item): ?>
                                            <?php if ($value['product_id'] == $item['product_id']): ?>
                                                <div class="col-xs-6 col-md-4 col-lg-3">
                                                    <span>SN <?php echo $item['serial_number'] ?></span>
                                                </div>
                                                <?php endif; ?>
                                            <?php endforeach ?>
                                        </div>
                                        
                                        
                                        </td>

										<td class="text-right"><strong><?php echo $value["quantity"];?> Pcs</strong></td>
										 
									  </tr>
	                            <?php endforeach ?>

	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    <div class="row">
	     
		<div class="col-xs-3">
			<br><br><br>
			<p class="text-center">___________________</p>
			<p class="text-center">ผู้ส่งสินค้า</p>
			<p class="text-center">วันที่......./......./.......</p>

		</div>
		<div class="col-xs-3">
			<br><br><br>
			<p class="text-center">___________________</p>
			<p class="text-center">ผู้รับสินค้า</p>
			<p class="text-center">วันที่......./......./.......</p>

		</div>
		<div class="col-xs-3">
			<br><br><br>
			<p class="text-center">___________________</p>
			<p class="text-center">ผู้ตรวจสอบ</p>
			<p class="text-center">วันที่......./......./.......</p>

		</div>
		<div class="col-xs-3">
			<br><br><br>
			<p class="text-center">___________________</p>
			<p class="text-center">ผู้อนุมัติ</p>
			<p class="text-center">วันที่......./......./.......</p>

		</div>
	    		  	 
		</div>
		<div class="row noprint">
			<p class="text-center"><br><br><br>
			<button type="button" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> พิมพ์</button>
			<a class="btn btn-success" href="<?php echo base_url("delivery_note");?>" role="button">ปิดหน้าต่างนี้</a>
			</p>
		</div>
	</div>

<style>

.height {

}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
.table-condensed>tbody>tr>td{
	padding: 2px;
}


.lineover{
  /* Fallback for non-webkit */
  display: -webkit-box;
  /* Fallback for non-webkit */
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-id{
	width: 150px;
}
.sumprice{
	width: 150px;
}
.sumpricepernum{
	width: 80px;
}
  @media print {
      a[href]:after {
        content: "" !important;
      }
    }

 @media print {
    .noprint {
        display: none;
    }
}
</style>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
 
         <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
</body>
</html>
