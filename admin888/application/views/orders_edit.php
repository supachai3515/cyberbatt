<div id="page-wrapper" ng-app="myApp">
    <div class="container-fluid" ng-controller="order">

          <script type="text/ng-template" id="myModalContent.html">
          <div class="modal-header">
              <h3 class="modal-title" ng-bind="product_serial[0].sku +' : '+ product_serial[0].product_name">Stock สินค้า </h3>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" novalidate>

                    <div class="form-group">
                          <label class="col-md-2 control-label"><p class="text-center">ลำดับ</p></label>
                          <label class="col-md-6 control-label"><p class="text-center">Serial Number</p></label>
                          <label class="col-md-4 control-label"><p class="text-center">วันที่บันทึก</p></label>

                      </div>


                  <!-- Text input-->
                  <div ng-repeat="value in product_serial">
                      <div class="form-group">
                          <label class="col-md-2 control-label"><span ng-bind="value.line_number"></span></label>
                          <div class="col-md-6">
                              <input type="text" class="form-control input-md" ng-model="product_serial.serial_number[value.line_number]"  ng-init="product_serial.serial_number[value.line_number] = value.serial_number " enter>
                          </div>
                          <label class="col-md-4 control-label"><span ng-bind="value.modified_date_order"></span></label>
              
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-12">
                        <p class="text-danger">{{txtError}}</p>
                        <p class="text-success">{{txtSuccess}}</p>
                      </div>
                  </div>
                  <!-- Button -->
                  <div class="form-group">
                      <label class="col-md-3 control-label" for="save"></label>
                      <div class="col-md-4">
                          <button type="button" class="btn btn-primary" ng-click="save_serial()">บันทึก</button>
                      </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
          </div>
      </script>


        <div class="page-header">
          <h1>ใบสั่งซื้อสินค้า <strong>#<?php echo $orders_data['id'] ?></h1>
        </div>
        <div style="padding-top:30px;"></div>

        <form action="<?php echo base_url('orders/update_status/'.$orders_data['id']); ?>" method="POST" class="form-inline" role="form">
          <div class="form-group">
            <label class="sr-only" for="">สถานะ</label>
             <select id="select_status" name="select_status" class="form-control">
                <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == $orders_data['order_status_id']): ?>
                        <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                    <?php else: ?>
                        <option value="<?php echo $status['id']; ?>"><?php echo $status['name']; ?></option>
                    <?php endif ?>          
                <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="">description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด">
          </div>
      
          <button type="submit" class="btn btn-primary">เปลี่ยน</button>
        </form>

        <div class="row">
          <div class="col-md-8">
            <h4 class="text-info">ข้อมูลการสั่งซื้อ</h4>
            <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>สถานะ</th>
                          <th>#</th>
                          <th>จำนวน</th>
                          <th>ส่งไปยัง</th>
                          <th>รวม</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>
                              <strong><?php echo $orders_data['order_status_name'];?></strong><br/>
                               <?php if (isset($orders_data['trackpost'])) : ?>
                                <?php if ($orders_data['trackpost'] !=""): ?>
                                   <span>traking : </span>  <strong><?php echo $orders_data['trackpost'];?></strong><br/>
                                <?php endif ?>
                              <?php endif ?>
                          </td>
                          <td>
                              <span>เลขที่ใบเสร็จ : <strong>#<?php echo $orders_data['id'] ?></strong></span><br/>
                              <span>โดย : <strong><?php echo $orders_data['name'] ?></strong></span><br/>
                              <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($orders_data['date']));?></span>

                          </td>
                          <td>
                              <span><strong><?php echo $orders_data['quantity'] ?></strong> item</span><br/>
                          </td>
                          <td>
                              <strong>ที่อยู่ : </strong><span><?php echo $orders_data['address']; ?></span><br/>
                              <strong>วิธีการจัดส่ง : </strong><span><?php echo $orders_data['shipping']; ?></span><br/>
                              <strong>อีเมลล์ : </strong><span><?php echo $orders_data['email']; ?></span><br/>
                              <strong>เบอร์โทร : </strong><span><?php echo $orders_data['tel']; ?></span><br/>
                              <?php if ($orders_data['is_tax']=="1"): ?>
                                <h4>ออกใบกำภาษี</h4>
                                 <strong>เลขที่ผุ้เสียภาษี : </strong><span><?php echo $orders_data['tax_id']; ?></span><br/>
                                 <strong>บริษัท : </strong><span><?php echo $orders_data['tax_company']; ?></span><br/>
                                <strong>ที่อยู่ : </strong><span><?php echo $orders_data['tax_address']; ?></span><br/>
                          
                            <?php endif ?>
                             
                          </td>
                             
                          <td>
                               <strong ng-bind="<?php echo $orders_data['total'];?> | currency:'฿':0"></strong>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>

          <h4 class="text-info">รายละเอียดสินค้า</h4>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>sku</th>
                  <th>name</th>
                  <td>quantity</td>
                  <td>price</td>
                  <td>vat</td>
                  <td>total</td>
                </tr>
              </thead>
              <tbody>
              <?php  $sum_price=0; foreach ($orders_detail as $value): ?>
                <tr>
                  <td><?php echo  $value['sku'] ?></td>
                  <td>
                    <?php echo  $value['product_name'] ?> <br/>
                    <button type="button" class="btn btn-info btn-xs" ng-click="open(<?php echo  $value['product_id'] ?>,<?php echo  $value['quantity'] ?>,<?php echo $orders_data['id'] ?>)">Serial Number</button>
                  </td>
                  <td><?php echo  $value['quantity'] ?></td>
                  <td><?php echo  $value['price'] ?></td>
                  <td><?php echo  $value['vat'] ?></td>
                  <td><?php echo  $value['total']?></td>
                </tr>

              <?php $sum_price = $sum_price+($value['total']-$value['vat']); endforeach ?>

                <tr>
                  <td colspan="5" class="text-right"><strong>รวม</strong></td>
                  <td class="text-right"><ins ><?php echo  $sum_price ?></ins></td>
                </tr>

                <tr>
                  <td colspan="5" class="text-right"><strong>vat</strong></td>
                  <td class="text-right"><ins ><?php echo  $orders_data['vat'] ?></ins></td>
                </tr>
                <tr>
                  <td colspan="5" class="text-right"><strong>ค่าจัดส่ง</strong></td>
                  <td class="text-right"><ins class="text-right"><?php echo  $orders_data['shipping_charge'] ?></ins></td>
                </tr>
                 <tr>
                  <td colspan="5" class="text-right"><strong>รวมทั้งหมด</strong></td>
                  <td class="text-right"><ins class="text-right"><?php echo  $orders_data['total'] ?></ins></td>
                </tr>
                
              </tbody>
            </table>
              <?php if ($orders_data['order_status_id'] >= "2" && $orders_data['order_status_id'] < "5"): ?>
                  <form action="<?php echo base_url('orders/update_tracking/'.$orders_data['id']); ?>" method="POST" class="form-inline" role="form">
              <div class="form-group">
                <label class="sr-only" for="">tracking</label>
                <input type="text" class="form-control" id="tracking" name="tracking"
                <?php if (isset($orders_data['trackpost'])): ?>
                  value="<?php echo $orders_data['trackpost']; ?>"
                <?php endif ?>
                 placeholder="tracking number" required="true">
              </div>
              <div class="form-group">
                 <select id="select_status" name="select_status" class="form-control" readonly="true">
                <?php foreach ($order_status_list as $status): ?>
                    <?php if ($status['id'] == "4"): ?>
                        <option value="<?php echo $status['id']; ?>" selected><?php echo $status['name']; ?></option>
                    <?php endif ?>          
                <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label class="sr-only" for="">description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="รายละเอียด" >
          </div>

          
              <button type="submit" class="btn btn-primary">ส่งรหัส tracking</button>
            </form>

                
              <?php endif ?>
          </div>
          <br>

            <div class="well">

               <form class="form-horizontal" method="POST" action="<?php echo base_url('orders/save_slip/'.$orders_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
               <div class="form-group">
                  <legend>รูป slip</legend>
                </div>


                <!-- File Button --> 
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="image_field">รูปสำหรับลูกค้า</label>
                    <div class="col-md-6">
                      <p><input id="image_field" name="image_field" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>
                      
                    </div>
                  </div>

                  <!-- File Button --> 
                  <div class="form-group">
                    <label class="col-md-3 control-label" for="image_field1">รูปสำหรับเจ้าหน้าที่</label>
                    <div class="col-md-6">
                      <p><input id="image_field1" name="image_field1" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1"></p>
                      
                    </div>
                  </div>

                <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" value="upload"  class="btn btn-success">บันทึก slip</button>
                  </div>
                </div>
            </form>

            </div>
        
          </div>


          <div class="col-md-4">
            <a href="<?php echo $this->config->item('weburl').'/invoice/'.$orders_data['ref_id']; ?>" target="_blank"><button type="button" class="btn btn-success">ใบสั่งซื้อ</button></a>

            <h4 class="text-info">สถานะสินค้า</h4>
            <div class="well">
              <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>status</th>
                    <th>description</th>
                    <th>วันที่</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($order_status_history_list as $value): ?>
                  <tr>
                    <td><?php echo  $value['order_status_name'] ?></td>
                    <th><?php echo  $value['description'] ?></th>
                    <th><?php echo date("d-m-Y H:i", strtotime($value['create_date']));?></th>
                  </tr>
                <?php endforeach ?>
                  
                </tbody>
              </table>
            </div>
              
            </div>

          </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
