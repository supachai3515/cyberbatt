<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ใบขอซื้อ</title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

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
            		<h4>บริษัท ไซเบอร์ แบต จำกัด</h4>
			  		 2963 ซ.ลาดพร้าว 101/2 ถ.ลาดพร้าว คลองจั่น บางกะปิ กทม. 10240<br>
			  		 โทร 02-7313565 มือถือ 081-7547565<br>
			  		 <strong>เลขประจำตัวผู้เสียภาษี 0105553076314</strong>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <h3>ใบส่งคืน supplier<br>
					<?php //print_r($returns_supplier_data) ?>
                    <?php echo  $returns_supplier_data['doc_no'];?> </h3>
                    <strong>วันที่ <?php echo $returns_supplier_data['create_date']?></strong><br/>

            	</div>
		</div>
        <div class="row" style="padding-top:10px;">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default height">
                  <div class="panel-heading">ผู้จำหน่าย</div>
                  <div class="panel-body">
                      <?php if (isset($returns_supplier_data["supplier_id"]) && $returns_supplier_data["supplier_id"] !=""): ?>
                      	<strong>Supplier: </strong><?php echo $returns_supplier_data["supplier_name"];?><br>
					<?php endif; ?>
									
                  </div>
              </div>
          </div>
		</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>รายละเอียดสินค้า</h4>
            </div>
        </div>
	    <div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-body">
	                    <div class="table-responsive">
	                        <table class="table table-condensed">
	                            <thead>
	                                <tr>
	                                    <td class="text-center product-id"><strong>serial number</strong></td>
	                                    <td class=""><strong>Name</strong></td>
										<td class=""><strong>Model</strong></td>
										<td class=""><strong>comment</strong></td>
	                                    <td class="text-center sumpricepernum"><strong>QTY</strong></td>
	                                </tr>
	                            </thead>
	                            <tbody>
									         <?php
									              $vat = 0;
									              $total = 0;
									              $priceTotal =0;
									          ?>

													<?php foreach ($returns_supplier_detail_data as $value): ?>
														<?php
										                    $total = $total+ $value['total'];
										                    $priceTotal = $priceTotal + ($value["price"]*$value["qty"]);
										                 ?>
											               <tr>
															<td class="text-center"><?php echo $value['serial_number'] ?></td>
															<td><?php echo $value['name'] ?></td>
															<td><?php echo $value['model'] ?></td>
															<td><?php echo $value['comment'] ?></td>
										                    <td class="text-center"><?php echo $value['qty'] ?></td>
														</tr>
															<?php endforeach; ?>
													</tbody>
												</table>
	                </div>
	            </div>
	        </div>
	    </div>
			<div class="row">
	    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    		<div class="panel panel-default">
	    		 <div class="panel-heading">การชำระเงิน</div>
	    		<div class="panel-body">
	    		  <div class="row">
	    		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  		<p class="text-center"><br></p>
	    		  		<br>
	    		  		<br>
	    		  		<br>
	    		  		<div class="row">
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		ผู้จัดทำ
			    		  		</p>
	    		  			</div>
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		วันที่
			    		  		</p>
	    		  			</div>
	    		  		</div>

	    		  	</div>
	    		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  		<p class="text-center">ในนาม บริษัท ไซเบอร์ แบต จำกัด</p>
	    		  		<br>
	    		  		<br>
	    		  		<br>
	    		  		<div class="row">
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		ผู้อนุมัติ
			    		  		</p>
	    		  			</div>
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		วันที่
			    		  		</p>
	    		  			</div>
	    		  		</div>

	    		  	</div>
	    		  </div>
	    		</div>
	    	</div>

			</div>


		<div class="row noprint">

			<p class="text-center">
			<button type="button" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> พิมพ์ใบส่งคืน</button>
			<a class="btn btn-success" href="<?php echo base_url();?>" role="button">ปิดหน้าต่างนี้</a>
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
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
</body>
</html>
