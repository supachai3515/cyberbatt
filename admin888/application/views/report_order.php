<div id="page-wrapper" ng-app="myApp">
    <div class="container-fluid" ng-controller="myCtrl">
        <div class="page-header">
            <h1>รายงานชำระเงิน 
            <?php if($this->input->get("method") == 'post'){?><small style="float:right">
            	<a href="<?php echo base_url('report_order');?>"><button style="color:#000;" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i>&nbsp;โชว์ข้อมูลทั้งหมด</button></a>
            </small>
			<?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="?method=post" method="post" class="form-inline" role="form">
        	<div class="form-group">
            	<label for="">รายชื่อธนาคาร</label>
                <select name="list_category" id="list_category" style="height:30px;" class="form-control"> 
                    <option value="0">ทั้งหมด</option>
                    <option value="ธนาคารกรุงเทพ" <?php if($resultpost['list_category'] == 'ธนาคารกรุงเทพ'){echo "selected";}?>>ธนาคารกรุงเทพ</option>
                    <option value="ธนาคารกรุงไทย" <?php if($resultpost['list_category'] == 'ธนาคารกรุงไทย'){echo "selected";}?>>ธนาคารกรุงไทย</option>
                    <option value="ธนาคารไทยพาณิชย์" <?php if($resultpost['list_category'] == 'ธนาคารไทยพาณิชย์'){echo "selected";}?>>ธนาคารไทยพาณิชย์</option>
                    <option value="ธนาคารกสิกรไทย" <?php if($resultpost['list_category'] == 'ธนาคารกสิกรไทย'){echo "selected";}?>>ธนาคารกสิกรไทย</option>
                    <option value="ใบลดหนี้" <?php if($resultpost['list_category'] == 'ใบลดหนี้'){echo "selected";}?>>ใบลดหนี้</option>
                </select>
            </div>
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
    		<div class="form-group">
            	<label><input type="checkbox" value="1" name="checkbank" <?php if($this->input->get("method") == 'post'){echo (empty($resultpost['checkbank']) != 1 ? 'checked="checked"' : '');}?>>รายละเอียด</label>
          	</div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align:center">ลำดับ</th>
                        <th style="text-align:center">รายชื่อธนาคาร</th>
                        <th style="text-align:center">จำนวนเงินที่โอนมาทั้งหมด</th>
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
                            <td align="center"><?php echo $dw['bank_name'];?></td>
                            <td align="center"><?php 
							echo number_format((empty($resultpost['checkbank']) != 1 ? $dw['amount'] : $dw['sum']),2);
							?>
                            </td>
                        </tr>
                        <?php 
						$total = $total + (empty($resultpost['checkbank']) != 1 ? $dw['amount'] : $dw['sum']);
						$number++;?>
                        <?php endforeach;?>
                    <?php }?>
                    <?php 
					if($this->input->get("method") == 'post'){
						if(count($selectDB) != 0){?>
							<tr>
								<td style="text-align:center" colspan="2"><strong>รวมยอดขายทั้งหมด</strong></td>
								<td align="center"><?php echo number_format($total,2);?></td>
							</tr>
						<?php }
					}?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->