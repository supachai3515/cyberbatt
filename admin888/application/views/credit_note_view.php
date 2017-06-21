<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ใบรับเข้า <?php echo $credit_note_data['docno']." ".$credit_note_data["order_id"];?></title>

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
            		<h4>บริษัท ไชเบอร์ แบต จำกัด</h4>
			  		 2963 ซ.ลาดพร้าว 101/2 ถ.ลาดพร้าว คลองจั่น บางกะปิ กทม. 10240<br>
			  		 โทร 02-7313565 มือถือ 081-7547565<br>
			  		 <strong>เลขประจำตัวผู้เสียภาษี 0105553076314</strong>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <h3>ใบลดหนี้<br>
                    <?php if ($credit_note_data['is_refund'] == 0): ?>
                            <span style="font-size:14px"> ยังไม่คืนเงิน </span>
                    <?php else: ?>
                            <span style="font-size:14px"> คืนเงิน </span>
                    <?php endif ?>
    				<?php
					/*Order*/
					$queryorder = $this->db->query("select * from orders where id = '".$credit_note_data['order_id']."'")->result_array();
					foreach($queryorder as $qor)
					?>
                    <?php echo  $credit_note_data['docno'];?> </h3>
                    <strong>วันที่แจ้งลดหนี้ <?php echo $credit_note_data['create_date']?></strong><br/>
                    <strong>Ref. #<?php echo $qor['ref_id']?></strong><br/>
            	</div>
		</div>
        <div class="row" style="padding-top:10px;">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default height">
                  <div class="panel-heading">ข้อมูลลูกค้า</div>
                  <div class="panel-body">
                      <strong>ชื่อลูกค้า: </strong><?php echo $qor["name"];?><br>
                      <strong>ที่อยู่จัดส่ง: </strong><?php echo $qor["address"];?><br>
                  </div>
              </div>
          </div>
		</div>
        <div class="row" style="padding-top:10px;">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="panel panel-default height">
                  <div class="panel-heading">หมายเหตุ</div>
                  <div class="panel-body">
                      <strong>หมายเหตุ: </strong><?php echo $credit_note_data["comment"];?><br>
                      <?php if ($credit_note_data['is_refund'] == 1){?>
                      <strong>รูปสลิป: </strong><?php if($credit_note_data['note_img'] != ''){?><img src="<?php echo $this->config->item('url_img').$credit_note_data['note_img'];?>" width="150"><?php }?><br>
                      <?php }?>
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
	                                    <td class="text-center product-id">sku</td>
	                                    <td class="text-center">name</td>
	                                    <td class="text-center sumpricepernum">qty</td>
                                        <td class="text-center">vat</td>
	                                    <td class="text-center">price</td>
	                                    <td class="text-center">total</td>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            <?php 
								$pro_detail = $this->db->query("SELECT * FROM order_detail LEFT JOIN products ON(products.id = order_detail.product_id) WHERE order_detail.order_id = '".$qor['id']."'")->result_array();
								foreach ($pro_detail as $value): ?>
	                            	 <tr>
										<td class="text-center"><?php echo $value['sku'] ?></td>
										<td><?php echo $value['name'] ?></td>
                                        <td class="text-center"><?php echo $value['quantity'] ?></td>
										<td class="text-center"><?php echo $value['vat']; ?></td>
										<td class="text-center"><?php echo number_format($value["price"]*$value["quantity"],2);?></td>
										<td class="text-center"><?php echo number_format($value['total'],2);?></td>
									  </tr>
	                            <?php endforeach ?>
								  	<tr>
                                    	<td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="highrow text-center sumprice" >รวมราคาสินค้า</td>
	                                    <td class="highrow text-right"><?php echo number_format($qor["total"],2);?>&nbsp;บาท</td>
	                                </tr>
	                                <tr>
                                    	<td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center" >VAT(7%)</td>
	                                    <td class="emptyrow text-right"><?php echo number_format($qor["vat"],2)."&nbsp;บาท"; ?></td>
	                                </tr>
	                                 <tr>
	                                 	<td class="emptyrow"></td>
                                        <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center ">รวมราคาสุทธิ</td>
	                                    <td class="emptyrow text-right text-danger"><strong><?php echo number_format($qor["total"],2);?>&nbsp;บาท</strong></td>
	                                </tr>

	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    
		<div class="row noprint">

			<p class="text-center">
			<button type="button" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> พิมพ์ใบชำระเงิน</button>
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
