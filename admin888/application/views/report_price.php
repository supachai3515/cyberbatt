<div id="page-wrapper" ng-app="myApp">
    <div class="container-fluid" ng-controller="myCtrl">
        <div class="page-header">
            <h1>รายงานยอดขายสินค้า 
            <?php if($this->input->get("method") == 'post'){?><small style="float:right">
            	<a href="<?php echo base_url('report_order/report_product');?>"><button style="color:#000;" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i>&nbsp;โชว์ข้อมูลทั้งหมด</button></a>
            </small>
			<?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="?method=post" method="post" class="form-inline" role="form">
            <div class="form-group">
            	<span id="startDate" style="display:none"><?php echo DATE;?></span>
                <label for="">วันที่เริ่มต้นค้นหา</label>
                <input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="วันที่เริ่มต้นค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateStart'] == '' ? DATE : $resultpost['dateStart']);}?>">
            </div>
            <div class="form-group">
            	<span id="endDate"></span>
                <label for="">วันที่สิ้นสุดการค้นหา</label>
                <input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="วันที่สิ้นสุดการค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateEnd'] == '' ? DATE : $resultpost['dateEnd']);}?>">
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center">ลำดับ</th>
                        <th style="text-align:center">วันที่</th>
                        <th style="text-align:center">จำนวน</th>
                        <th style="text-align:center">ราคาvat</th>
                        <th style="text-align:center">ราคาทั้งหมด</th>
                    </tr>
                </thead>
                <tbody> 
					<?php
                    $number = 1;
                    ?>
                    <?php if(count($selectDB) == 0){?>
                    <tr>
                        <td colspan="9" align="center" style="color:red;"><strong>ไม่มีข้อมูล</strong></td>
                    </tr>
                    <?php }else{
                        $discountbill = 0;
						$total = 0;
                        foreach($selectDB as $dw):
                        ?>
                        <tr>
                            <td style="text-align:center"><strong><?php echo $number;?></strong></td>
                            <td align="center"><?php echo $dw['orDATE'];?></td>
                            <td align="center"><?php echo $dw['orQTY'];?></td>
                            <td align="center"><?php echo number_format($dw['orVAT'],2);?></td>
                            <td align="center"><?php echo number_format($dw['sum_total'],2);?></td>
                        </tr>
                        <?php 
						$total = $total + $dw['sum_total'];
						$number++;?>
                        <?php endforeach;?>
                    <?php }?>
                    <?php 
					if($this->input->get("method") == 'post'){
						if(count($selectDB) != 0){?>
							<tr>
								<td style="text-align:center" colspan="4"><strong>รวมยอดขายทั้งหมด</strong></td>
								<td align="center"><?php echo number_format($total,2);?></td>
							</tr>
                        <?php }?>
					<?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->